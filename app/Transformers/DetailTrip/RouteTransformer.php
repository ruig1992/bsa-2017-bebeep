<?php

namespace App\Transformers\DetailTrip;

use App\Services\Result\RouteDetail;
use League\Fractal\TransformerAbstract;

class RouteTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'bookings',
    ];

    /**
     * A Fractal transformer.
     *
     * @param \App\Services\Result\RouteDetail $route
     * @return array
     */
    public function transform(RouteDetail $route) : array
    {
        return [
            'id' => $route->id,
            'from' => [
                'lng' => $route->from['geometry']['location']['lng'],
                'lat' => $route->from['geometry']['location']['lat'],
                'short_address' => $route->from['address_components'][0]['short_name'],
                'address' => $route->from['formatted_address'],
            ],
            'to' => [
                'lng' => $route->to['geometry']['location']['lng'],
                'lat' => $route->to['geometry']['location']['lat'],
                'short_address' => $route->to['address_components'][0]['short_name'],
                'address' => $route->to['formatted_address'],
            ],
            'start_at_x' => $route->start_at->timestamp,
            'end_at_x' => $route->end_at->timestamp,
            'reserved_seats' => $route->reservedSeats,
            'price' => $route->price,
        ];
    }

    /**
     * @param \App\Services\Result\RouteDetail $route
     * @return \League\Fractal\Resource\Collection
     */
    public function includeBookings(RouteDetail $route)
    {
        return $this->collection($route->approvedBookings, new BookingTransformer());
    }
}
