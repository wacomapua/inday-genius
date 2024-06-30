<?php

namespace App\Http\Controllers;

use App\Mail\SendRecipe;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Jeybin\Toastr\Toastr;

class RecipeController extends Controller
{

    // index
    public function index()
    {
        $recipes = Recipe::all();
        return view('recipes.index', compact('recipes'));
    }

    // show
    public function show($request)
    {
//        dd($request);
        $recipe = Recipe::with('ingredients')->find($request);
        return view('recipes.show', compact('recipe'));
    }

    // create

    public function create()
    {
        return view('recipes.create');
    }

    // store
//    public function store(Request $request, User $user)
//{
//    $attributes = $request->validate([
//        'title' => 'required|string|max:255', // Ensuring the title is a string and has a maximum length.
//        'description' => 'required|string|max:500', // Ensuring the about is a string and has a maximum length.
//        'ingredients' => 'required|array', // Validates that ingredients is an array.
//        'ingredients.*' => 'required|string|distinct|min:1', // Validates each item in the ingredients array.
//        'quantities' => 'required|array', // Validates that quantities is an array.
//        'quantities.*' => 'required|numeric|min:0', // Validates each item in the quantities array must be numeric and non-negative.
//        'units' => 'required|array', // Validates that units is an array.
//        'units.*' => 'required|string|distinct|min:1', // Validates each item in the units array.
//        'instructions' => 'required|string', // Ensuring instructions is a string.
//        'file-upload' => 'nullable|file|mimes:jpg,jpeg,png,gif' // Validates the file is optional, must be a file, and must be one of the specified mime types.
//    ]);
//
//    $ingredients = collect($attributes['ingredients'])->map(function ($ingredient, $index) use ($attributes) {
//        return [
//            'name' => $ingredient,
//            'quantity' => $attributes['quantities'][$index],
//            'unit' => $attributes['units'][$index]
//        ];
//    });
//    // get the name of the ingredients and check if they exist, but only check the name
//    $ingredientRecipe = $ingredients->map(function ($ingredient) {
//        return $ingredient['name'];
//    });
//    //check if the ingredient exists in the ingredients table
//    $ingredientRecipe = Ingredient::firstOrCreate($ingredientRecipe->toArray());
//
//    dd($ingredientRecipe);
//    // get the id of the ingredients, and store them in the pivot table with the recipe id
//    $recipeAttributes['ingredients'] = $ingredientRecipe->pluck('id')->toArray();
//
//
//    $recipe = new Recipe($attributes);
//    $recipe->user_id = auth()->id();
//    $recipe->save();
//
//
//    return redirect()->route('recipes.index');
//}

    public function store(Request $request, User $user)
    {
        $attributes = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'ingredients' => 'required|array',
            'ingredients.*' => 'required|string|distinct|min:1',
            'quantities' => 'required|array',
            'quantities.*' => 'required|numeric|min:0',
            'units' => 'required|array',
            'units.*' => 'required|string|distinct|min:1',
            'instructions' => 'required|string',
            'file-upload' => 'nullable|file|mimes:jpg,jpeg,png,gif'
        ]);

        $ingredientIds = collect($attributes['ingredients'])->map(function ($ingredient, $index) use ($attributes) {
            $foundIngredient = Ingredient::firstOrCreate(['name' => $ingredient]);

            // Return ingredient ID and quantity, and units for pivot table
            return [
                'ingredient_id' => $foundIngredient->id,
                'quantity' => $attributes['quantities'][$index],
                'unit' => $attributes['units'][$index]
            ];
        });

        $recipe = new Recipe([
            'title' => $attributes['title'],
            'description' => $attributes['description'],
            'instructions' => $attributes['instructions'],
            // Other recipe attributes
        ]);
        $recipe->user_id = auth()->id(); // Or auth()->id() if you want the authenticated user
        $recipe->save();

        // Attach ingredients to the recipe with additional pivot data
        foreach ($ingredientIds as $ingredientData) {
            $recipe->ingredients()->attach($ingredientData['ingredient_id'], [
                'quantity' => $ingredientData['quantity'],
                'unit' => $ingredientData['unit']
            ]);
        }

        return redirect()->route('recipes.index');
    }

    // edit

    public function edit(User $user, Recipe $recipe)
    {

        return view('recipes.edit', compact('recipe'));
    }

    // update

    public function update(Request $request, $id)
    {
        return redirect()->route('recipes.index');
    }

    // destroy

    public function destroy($id)
    {
        return redirect()->route('recipes.index');
    }

    public function send(Request $request, Recipe $recipe)
    {
        Mail::to(auth()->user())->queue(new SendRecipe($recipe));
        Toastr::success('Recipe sent successfully')->toast();
        return redirect()->route('recipes.show', $recipe);
    }
}
