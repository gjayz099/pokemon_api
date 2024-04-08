<?php

namespace App\Http\Controllers;

use App\Http\Requests\PokemonRequest;
use App\Http\Resources\AbilityResource;
use App\Http\Resources\ExperienceResource;
use App\Http\Resources\PokemonResource;
use App\Http\Resources\TypeResource;
use App\Models\Ability;
use App\Models\Pokemon;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PokemonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $pokemon = Pokemon::with(['types', 'abilities', 'experiences'])->get();
    
            return response()->json([
                'data' => PokemonResource::collection($pokemon)
            ]);
    
        } catch (\Throwable $th) {
            echo('error your'. $th->getMessage());
            response()->json(["Internal Server Error", $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PokemonRequest $pokemonRequest)
    {
        try {
            $validatedData = $pokemonRequest->validated();
        
            $pokemon = Pokemon::create($validatedData);


            $experiencedata = $pokemonRequest->input('Base_experience');
            $experience = $pokemon->experiences()->create(['Base_experience' => $experiencedata]);
        

            $abilityData = [];
            foreach ($pokemonRequest->input('Ability_name') as $abilityName) {
                $ability = Ability::create(['Ability_name' => $abilityName, 'Pokemon_id' => $pokemon->id]);
                $abilityData[] = $ability;
            }

            $typedata = [];
            foreach ($pokemonRequest->input('Types_name') as $typeName) {
                $type = Type::create(['Type_name' => $typeName, 'Pokemon_id' => $pokemon->id]);
                $typedata[] = $type;
            }
        
            return response()->json([
                'pokemon' => new PokemonResource($pokemon),
                'types' => TypeResource::collection($typedata),
                'abilities' => AbilityResource::collection($abilityData),
                'experiences' => ExperienceResource::make($experience)
            ]);
        } catch (\Throwable $th) {
            echo('error your'. $th->getMessage());
            response()->json(["Internal Server Error", $th->getMessage()], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $pokemon = Pokemon::with(['types', 'abilities', 'experiences'])->findOrFail($id);

            return response()->json([
                'data' => new PokemonResource($pokemon)
            ]);
        } catch (\Throwable $th) {
            echo('error your'. $th->getMessage());
            response()->json(["Internal Server Error", $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'Name' => 'required|string',
                'Picture' => 'url',
                'Types_name' => 'required|array',
                'Types_name.*' => 'string',
            ]);
        
            // Return validation errors if any
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
        
        
            $pokemon = Pokemon::findOrFail($id);
        
            $pokemon->update($request->only(['Name', 'Picture']));
        
            $experiencedata = $request->input('Base_experience');
            $experience = $pokemon->experiences()->updateOrCreate(['Base_experience' => $experiencedata]);

            $abilityData = [];
            foreach ($request->input('Ability_name') as $abilityName) {
                $ability = $pokemon->abilities()->updateOrCreate(['Ability_name' => $abilityName]);
                $abilityData[] = $ability;
            }


            $typedata = [];
            foreach ($request->input('Types_name') as $typeName) {
                $type = $pokemon->types()->updateOrCreate(['Type_name' => $typeName]);
                $typedata[] = $type;
            }

            
        
            // Return the updated Pokemon and Type data
            return response()->json([
                'pokemon' => new PokemonResource($pokemon),
                'types' => TypeResource::collection($typedata),
                'abilities' => AbilityResource::collection($abilityData),
                'experiences' => ExperienceResource::make($experience)
            ]);

        } catch (\Throwable $th) {
            echo('error your'. $th->getMessage());
            response()->json(["Internal Server Error", $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       try {
        $pokemon = Pokemon::findOrFail($id);
        if(!$pokemon) return response()->json(['error' => 'Pokemon not found'], 404);
    
        $pokemon->delete();
    
        return response(['Success Delete Data', $pokemon]);
       } catch (\Throwable $th) {
            echo('error your'. $th->getMessage());
            response()->json(["Internal Server Error", $th->getMessage()], 500);
       }
    
    }
}
