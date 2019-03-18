<?php

namespace App;

class GreetingGenerator
{
    public function getRandomGreeting()
    {
        $greetings = ['Welcome to', 'Hi there, you are at', 'Sup, this is'];
        $greeting  = $greetings[array_rand($greetings)];

        return $greeting;
    }
}