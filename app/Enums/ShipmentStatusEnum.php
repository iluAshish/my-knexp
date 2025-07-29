<?php

namespace App\Enums;

class ShipmentStatusEnum
{
    const RECEIVED = 'Shipment Received';
    const PROCESSING = 'Shipment Processing';
    const DEPARTED_FROM_DUBAI_AIRPORT = 'Departed from Dubai Airport';
	const ARRIVED_AT_AIRPORT = 'Arrived at Dubai Airport';
    const DEPARTED_FROM_AIRPORT = 'Departed from Manila Airport';
    const ARRIVED_AT_MANILA_AIRPORT = 'Arrived at Manila Airport';
	const VESSEL_DEPARTED_FROM_DUBAI_PORT = 'Vessel Departed from Dubai Port';
    const VESSEL_ARRIVED_AT_MANILA_PORT = 'Vessel Arrived at Manila Port';
    const CLEARANCE_PROCESSING = 'Clearance Processing';
	const ARRIVED_AT_SORTING_FACILITY = 'Arrived at Sorting Facility';
	const DEPARTED_FROM_BANGKOK_AIRPORT = 'Departed from Bangkok Airport';
    const OUT_FOR_DELIVERY = 'Out for Delivery';
    const DELIVERED = 'Delivered';

    public static function all()
    {
        return [
            self::RECEIVED,
            self::PROCESSING,
            self::DEPARTED_FROM_DUBAI_AIRPORT,
			self::ARRIVED_AT_AIRPORT,
            self::DEPARTED_FROM_AIRPORT,
            self::ARRIVED_AT_MANILA_AIRPORT,
            self::VESSEL_DEPARTED_FROM_DUBAI_PORT,
            self::VESSEL_ARRIVED_AT_MANILA_PORT,
            self::CLEARANCE_PROCESSING,
            self::ARRIVED_AT_SORTING_FACILITY,
			self::DEPARTED_FROM_BANGKOK_AIRPORT,
			self::OUT_FOR_DELIVERY,
			self::DELIVERED,
        ];
    }
}