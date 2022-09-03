<?php

namespace Tests\Feature;

use Tests\TestCase;

class VesselPositionsApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_route_noparams()
    {
        $response = $this->get('/api/vesselpositions');

        $response->assertStatus(200);
    }

    public function test_index_route_json()
    {
        $response = $this->withHeaders(['Content-Type' => 'application/json'])->get('/api/vesselpositions');

        $response->assertHeader('Content-Type', 'application/json');
    }

    public function test_index_route_ldjson()
    {
        $response = $this->withHeaders(['Content-Type' => 'application/ld+json'])->get('/api/vesselpositions');

        $response->assertHeader('Content-Type', 'application/ld+json');
    }

    public function test_index_route_xml()
    {
        $response = $this->withHeaders(['Content-Type' => 'application/xml'])->get('/api/vesselpositions');

        $response->assertHeader('Content-Type', 'application/xml');
    }

    public function test_index_route_csv()
    {
        $response = $this->withHeaders(['Content-Type' => 'text/csv'])->get('/api/vesselpositions');

        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    public function test_index_route_notsupported_contenttype(){
        $response = $this->withHeaders(['Content-Type' => 'application/octet-stream'])->get('/api/vesselpositions');

        $response->assertStatus(406);
    }
}
