<?php
// src/App/Services/SlugService

namespace App\Services;

use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * custom slug service
 * Class SlugService
 */
class SlugService
{
    private $slugger;

    
    /**
     * Constructor
     */
    public function __construct(SluggerInterface $slugger)
    {
        //* cause we cannot use the sluggerinterface in the method below
        //* we need to use the sluggerinterface in the constructor (injection method)
        $this->slugger = $slugger;
    }
    /**
     * transform string to slug
     * @param string $text
     * @return string
     */
    public function slug(string $string): string
    {
        return $this->slugger->slug($string)->lower();
    }
}