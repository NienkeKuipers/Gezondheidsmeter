<?php

// Deze functie kijkt naar je score en vertelt of het slecht, ok of goed is.
// Elk heeft ook een kleur: rood voor slecht, oranje voor ok en groen voor goed.
function translateToThreePointScale($score) {
    if ($score <= 1) {
        // Als je score 1 of minder is, is het niet zo goed (rood).
        return ['scale' => 'Onvoldoende', 'color' => 'Rood'];
    } else if ($score <= 2) {
        // Als je score tussen 1 en 2 is, gaat het wel (oranje).
        return ['scale' => 'Voldoende', 'color' => 'Oranje'];
    } else {
        // Als je meer dan 2 scoort, doe je het goed (groen)!
        return ['scale' => 'Goed', 'color' => 'Groen'];
    }
}
