<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-12 py-8">

            <h2 class="text-2xl font-bold mb-2 text-gray-800">{{ $recipe->title }}</h2>
            <img style="height: 192px; width: 192px; border-radius: 50%; margin-bottom: 16px;"
                 src="{{ $recipe->image }}" alt="Recipe Image">
            <div>
                <h3 class="text-xl font-bold text-gray-700">Ingredients</h3>
                <ul class="list-disc pl-5">
                    @foreach ($recipe->ingredients as $ingredient)
                        <li>{{ $ingredient->name }}
                            - {{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-4">
                <h3 class="text-xl font-bold text-gray-700">Instructions</h3>
                <p>{{ $recipe->instructions }}</p>
            </div>
        </div>

    </div>
</div>
