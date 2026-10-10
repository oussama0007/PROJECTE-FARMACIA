<?php

if (!isset($_SESSION["products"])) {

    $_SESSION["products"] = [
        [
            "id" => 1,
            "name" => "Crema hidratant",
            "description" => "Crema hidratant per a la cura diària de la pell.",
            "price" => 8.50,
            "category" => "Cura personal",
            "image" => "crema.jpg",
            "rating" => 4.5
        ],
        [
            "id" => 2,
            "name" => "Vitamina C",
            "description" => "Vitamin C Supplement",
            "price" => 12.90,
            "category" => "Vitamines",
            "image" => "vitamina.jpg",
            "rating" => 4.7
        ],

        [
            "id" => 3,
            "name" => "Crema solar SPF 50",
            "description" => "Protecció solar alta per a la pell.",
            "price" => 15.50,
            "category" => "Protecció solar",
            "image" => "solar.jpg",
            "rating" => 4.8
        ],
        [
            "id" => 4,
            "name" => "Gel de dutxa",
            "description" => "Gel suau per a la higiene corporal diària.",
            "price" => 4.95,
            "category" => "Higiene",
            "image" => "gel.jpg",
            "rating" => 4.3
        ],
        [
            "id" => 5,
            "name" => "Pasta de dents",
            "description" => "Pasta de dents per a la higiene bucal diària.",
            "price" => 3.80,
            "category" => "Higiene",
            "image" => "pasta-dents.jpg",
            "rating" => 4.4
        ]
    ];
}