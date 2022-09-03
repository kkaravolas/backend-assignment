<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VesselPosition;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

/**
 * @OA\Get(
 * path="/api/vesselpositions",
 * summary="Retrieve vessel positions (supports filtering)",
 * description="Retrieve vessel position by mmsi, latitude/longitude range, timestamp range. If no filters provided, the response returns all vessel positions.",
 * operationId="vesselPositions",
 * tags={},
 * @OA\Parameter ( name="mmsi", in="query", description="Filter by Vessel ID (integer). Example mmsi=247039300", required=false ),
 * @OA\Parameter ( name="lon_from", in="query", description="Filter by minimum longitute (float). Example lon_from=15.4415", required=false ),
 * @OA\Parameter ( name="lon_to", in="query", description="Filter by maximum longitude (float). Example lon_to=19.3214", required=false ),
 * @OA\Parameter ( name="lat_from", in="query", description="Filter by minimum latitude (float). Example lat_from=34.67008", required=false ),
 * @OA\Parameter ( name="lat_to", in="query", description="Filter by maximum latitude (float). Example lat_to=41.2323", required=false ),
 * @OA\Parameter ( name="time_from", in="query", description="Filter by minimum timestamp (integer). Example time_from=1372666500", required=false ),
 * @OA\Parameter ( name="time_to", in="query", description="Filter by maximum timestamp (integer). Example time_to=1372683960", required=false ),
 * @OA\Response(
 *    response=200,
 *    description="Returns the ships positions in various formats, according to the Content-Type header of the request."
 *     ),
 * @OA\Response(
 *    response=429,
 *    description="Returned when max attempts limit is reached (default 10 per minute per ip address."
 *     ),
 * @OA\Response(
 *    response=406,
 *    description="Returned when a not supported content-type for the response is requested."
 *     )
 * )
 */

class VesselPositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    private const MIN_LON = 0;
    private const  MIN_LAT = 0;
    private const  MAX_LON = 90;
    private const  MAX_LAT = 90;

    private $supportedContentTypes = ['application/ld+json', 'application/json', 'application/xml', 'text/csv'];

    public function index()
    {
        $selectedVesselPosition = VesselPosition::query();

        if(request()->has('mmsi'))
            $selectedVesselPosition->whereIn('mmsi', explode(',',request()->get('mmsi')));

        if(request()->has("lat_from") || request()->has("lat_to")){
            $latFrom = request()->has("lat_from") ? request()->get('lat_from') : self::MIN_LAT;
            $latTo = request()->has("lat_to") ? request()->get('lat_to') : self::MAX_LAT;

            $selectedVesselPosition->whereBetween('lat', [$latFrom, $latTo]);
        }

        if(request()->has("lon_from") || request()->has("lon_to")){
            $lonFrom = request()->has("lon_from") ? request()->get('lon_from') : self::MIN_LON;
            $lonTo = request()->has("lon_to") ? request()->get('lon_to') : self::MAX_LON;

            $selectedVesselPosition->whereBetween('lon', [$lonFrom, $lonTo]);
        }

        if(request()->has("time_from") || request()->has("time_to")){
            $timeFrom = request()->has("time_from") ? request()->get('time_from') : 0;
            $timeTo = request()->has("time_to") ? request()->get('time_to') : 0;

            $selectedVesselPosition->whereBetween('timestamp', [$timeFrom, $timeTo]);
        }

        $requestContentType = \request()->headers->get('CONTENT_TYPE', 'application/json');

        if(!in_array($requestContentType, $this->supportedContentTypes))
            return response(['error' => 'Requested content type is not supported. Supported content types: '.implode(',', $this->supportedContentTypes)])->setStatusCode(406);

        $responseData = Str::contains($requestContentType, 'xml') ? $selectedVesselPosition->get()->toXml('VesselPosition') : $selectedVesselPosition->get();

        return response($responseData)->header('Content-Type', $requestContentType);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //NOT NEEDED
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //NOT IMPLEMENTED
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //NOT IMPLEMENTED
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //NOT IMPLEMENTED
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //NOT IMPLEMENTED
    }
}
