<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SolicitudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function la_pagina_de_inicio_carga_correctamente()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}