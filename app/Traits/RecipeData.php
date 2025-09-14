<?php
namespace App\Traits;

trait RecipeData
{
    //reusable trait so we can share measurement and ingredient data between ingredients and steps factory
    protected array $measuringUnits = [
        'cup','tbsp','tsp','g','kg','oz','pinch','clove','slice','can'
    ];

    protected array $ingredients = [
        'scallop','ginger','lemon','curry','pork','goat','apples','orange',
        'chicken breast','salmon fillet','garlic','onion','tomato','bell pepper',
        'olive oil','butter','parsley','basil','oregano','rice','pasta',
        'soy sauce','brown sugar','honey','salt','black pepper','potatoes','carrot'
    ];

    protected array $actions = ['cut', 'boil', 'fry', 'steam', 'bake', 'grill', 'chop', 'preheat', 'simmer', 'stir'];

    protected array $mains = [
        'Chicken','Salmon','Pasta','Tofu','Veggie Bake','Curry','Stir-Fry','Risotto','Stew','Tart',
        'Lamb Chops','Beef Roast','Shrimp Skewers','Duck Breast','Quiche','Stuffed Peppers',
        'Seafood Paella','Pork Chops','Lentil Soup','Mushroom Risotto'
    ];
}
