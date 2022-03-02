<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Client;
use App\Models\EndLocation;
use App\Models\Markers;
use App\Models\StartLocation;
use App\Models\Tour;
use App\Models\Description;
use App\Models\Tours;
use App\Models\ToursLog;
use App\Models\User;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function __construct()
    {
        $auth = new Auth();
        return $auth;
    }

    public function create(Request $request)
    {
        $tour = new Tour();
        $start_location = new StartLocation();
        $end_location = new EndLocation();

        $tour->startAddress = $request->startAddress;
        $tour->startDate = $request->startDate;
        $tour->startHour = $request->startHour;
        $tour->endAddress = $request->endAddress;
        $tour->endDate = $request->endDate;
        $tour->endHour = $request->endHour;
        $tour->sent = $request->sent;
        $tour->status = $request->status;
        $tour->user = $this->__construct()->me()->getData()->id;
        $tour->nameUser = $request->nameUser;
        $tour->emailUser = $request->emailUser;
        $tour->save();

        $start_location->latitude = $request->startLocation['latitude'];
        $start_location->longitude = $request->startLocation['longitude'];
        $start_location->tour = $tour->id;
        $start_location->save();

        $end_location->latitude = $request->endLocation['latitude'];
        $end_location->longitude = $request->endLocation['longitude'];
        $end_location->tour = $tour->id;
        $end_location->save();

        foreach ($request->markers as $mark) {
            $markers = new Markers();
            $markers->title = $mark['title'];
            $markers->endHour = $mark['endHour'];
            $markers->iconType = $mark['iconType'];
            $markers->latitude = $mark['latitude'];
            $markers->longitude = $mark['longitude'];
            $markers->startAddress = $mark['startAddress'];
            $markers->startHour = $mark['startHour'];
            $markers->tour = $tour->id;
            $markers->save();

            foreach ($mark['toursLog'] as $log) {
                $tours_log = new ToursLog();
                $tours_log->animal = $log['animal'];
                $tours_log->tutor = $log['tutor'];
                $tours_log->endHour = $log['endHour'];
                $tours_log->startAddress = $log['startAddress'];
                $tours_log->startHour = $log['startHour'];
                $tours_log->markers = $markers->id;
                $tours_log->save();

                $start_location->latitude = $log['startLocation']['latitude'];
                $start_location->longitude = $log['startLocation']['longitude'];
                $start_location->tours_log = $tours_log->id;
                $start_location->save();

                $end_location->latitude = $log['endLocation']['latitude'];
                $end_location->longitude = $log['endLocation']['longitude'];
                $end_location->tours_log = $tours_log->id;
                $end_location->save();

                foreach ($log['description'] as $desc) {
                    $description = new Description();
                    $description->address = $desc['address'];
                    $description->latitude = $desc['coordinates']['latitude'];
                    $description->longitude = $desc['coordinates']['longitude'];
                    $description->date = $desc['date'];
                    $description->description = $desc['description'];
                    $description->hour = $desc['hour'];
                    $description->tours_log = $tours_log->id;
                    $description->save();
                }
            }
        }
        foreach ($request->tours as $tours) {
            $toursNew = new Tours();
            $toursNew->animal = $tours['animal'];
            $toursNew->tutor = $tours['tutor'];
            $toursNew->plan = $tours['plan'];
            $toursNew->endHour = $tours['endHour'];
            $toursNew->startAddress = $tours['startAddress'];
            $toursNew->startHour = $tours['startHour'];
            $toursNew->rest = $tours['rest'];
            $toursNew->water = $tours['water'];
            $toursNew->piss = $tours['piss'];
            $toursNew->poop = $tours['poop'];
            $toursNew->tour = $tour->id;
            $toursNew->save();

            $start_location->latitude = $tours['startLocation']['latitude'];
            $start_location->longitude = $tours['startLocation']['longitude'];
            $start_location->tours = $toursNew->id;
            $start_location->save();

            $end_location->latitude = $tours['endLocation']['latitude'];
            $end_location->longitude = $tours['endLocation']['longitude'];
            $end_location->tours = $toursNew->id;
            $end_location->save();

            foreach ($tours['description'] as $desc) {
                $description = new Description();
                $description->address = $desc['address'];
                $description->latitude = $desc['coordinates']['latitude'];
                $description->longitude = $desc['coordinates']['longitude'];
                $description->date = $desc['date'];
                $description->description = $desc['description'];
                $description->hour = $desc['hour'];
                $description->tours = $toursNew->id;
                $description->save();
            }
        }

        $tour = Tour::where('id', '=', $tour->id)
            ->with(
                [
                    'endLocation',
                    'startLocation',
                    'markers',
                    'markers.toursLog',
                    'markers.toursLog.animal',
                    'markers.toursLog.tutor',
                    'markers.toursLog.description',
                    'markers.toursLog.endLocation',
                    'markers.toursLog.startLocation',
                    'tours',
                    'tours.animal',
                    'tours.tutor',
                    'tours.plan',
                    'tours.description',
                    'tours.endLocation',
                    'tours.startLocation',
                ])
            ->get();

        $arrayTour = array();
        
        foreach ($tour as $t) {
            if ($t->sent === "1") {
                if ($t->status == "1") {
                    array_push($arrayTour, [
                        "id" => $t->id,
                        "idUser" => $t->user,
                        "nameUser"=> $t->nameUser,
                        "emailUser"=> $t->emailUser,
                        "endAddress" => $t->endAddress,
                        "endDate" => $t->endDate,
                        "endHour" => $t->endHour,
                        "endLocation" => $t['endLocation'],
                        "markers" => $t['markers'],
                        "sent" => true,
                        "startAddress" => $t->startAddress,
                        "startDate" => $t->startDate,
                        "startHour" => $t->startHour,
                        "startLocation" => $t->startLocation,
                        "status" => true,
                        "tours" => $t['tours']
                    ]);
                } else {
                    array_push($arrayTour, [
                        "id" => $t->id,
                        "idUser" => $t->user,
                        "nameUser"=> $t->nameUser,
                        "emailUser"=> $t->emailUser,
                        "endAddress" => $t->endAddress,
                        "endDate" => $t->endDate,
                        "endHour" => $t->endHour,
                        "endLocation" => $t['endLocation'],
                        "markers" => $t['markers'],
                        "sent" => true,
                        "startAddress" => $t->startAddress,
                        "startDate" => $t->startDate,
                        "startHour" => $t->startHour,
                        "startLocation" => $t->startLocation,
                        "status" => false,
                        "tours" => $t['tours']
                    ]);
                }
            } else {
                if ($t->status == "1") {
                    array_push($arrayTour, [
                        "id" => $t->id,
                        "idUser" => $t->user,
                        "nameUser"=> $t->nameUser,
                        "emailUser"=> $t->emailUser,
                        "endAddress" => $t->endAddress,
                        "endDate" => $t->endDate,
                        "endHour" => $t->endHour,
                        "endLocation" => $t['endLocation'],
                        "markers" => $t['markers'],
                        "sent" => false,
                        "startAddress" => $t->startAddress,
                        "startDate" => $t->startDate,
                        "startHour" => $t->startHour,
                        "startLocation" => $t->startLocation,
                        "status" => true,
                        "tours" => $t['tours']
                    ]);
                } else {
                    array_push($arrayTour, [
                        "id" => $t->id,
                        "idUser" => $t->user,
                        "nameUser"=> $t->nameUser,
                        "emailUser"=> $t->emailUser,
                        "endAddress" => $t->endAddress,
                        "endDate" => $t->endDate,
                        "endHour" => $t->endHour,
                        "endLocation" => $t['endLocation'],
                        "markers" => $t['markers'],
                        "sent" => false,
                        "startAddress" => $t->startAddress,
                        "startDate" => $t->startDate,
                        "startHour" => $t->startHour,
                        "startLocation" => $t->startLocation,
                        "status" => false,
                        "tours" => $t['tours']
                    ]);
                }
            }

        }

        return response()->json($arrayTour[0]);
    }

    public function listAll()
    {
        $tour = Tour::orderBy('id', 'DESC')
            ->with(
                [
                    'endLocation',
                    'startLocation',
                    'markers',
                    'markers.toursLog',
                    'markers.toursLog.animal',
                    'markers.toursLog.tutor',
                    'markers.toursLog.description',
                    'markers.toursLog.endLocation',
                    'markers.toursLog.startLocation',
                    'tours',
                    'tours.animal',
                    'tours.tutor',
                    'tours.plan',
                    'tours.description',
                    'tours.endLocation',
                    'tours.startLocation',
                ])
            ->get();
        $arrayTour = array();

        foreach ($tour as $t) {

            if ($t->sent === "1") {
                if ($t->status == "1") {
                    array_push($arrayTour, [
                        "id" => $t->id,
                        "idUser" => $t->user,
                        "nameUser"=> $t->nameUser,
                        "emailUser"=> $t->emailUser,
                        "endAddress" => $t->endAddress,
                        "endDate" => $t->endDate,
                        "endHour" => $t->endHour,
                        "endLocation" => $t['endLocation'],
                        "markers" => $t['markers'],
                        "sent" => true,
                        "startAddress" => $t->startAddress,
                        "startDate" => $t->startDate,
                        "startHour" => $t->startHour,
                        "startLocation" => $t->startLocation,
                        "status" => true,
                        "tours" => $t['tours']
                    ]);
                } else {
                    array_push($arrayTour, [
                        "id" => $t->id,
                        "idUser" => $t->user,
                        "nameUser"=> $t->nameUser,
                        "emailUser"=> $t->emailUser,
                        "endAddress" => $t->endAddress,
                        "endDate" => $t->endDate,
                        "endHour" => $t->endHour,
                        "endLocation" => $t['endLocation'],
                        "markers" => $t['markers'],
                        "sent" => true,
                        "startAddress" => $t->startAddress,
                        "startDate" => $t->startDate,
                        "startHour" => $t->startHour,
                        "startLocation" => $t->startLocation,
                        "status" => false,
                        "tours" => $t['tours']
                    ]);
                }
            } else {
                if ($t->status == "1") {
                    array_push($arrayTour, [
                        "id" => $t->id,
                        "idUser" => $t->user,
                        "nameUser"=> $t->nameUser,
                        "emailUser"=> $t->emailUser,
                        "endAddress" => $t->endAddress,
                        "endDate" => $t->endDate,
                        "endHour" => $t->endHour,
                        "endLocation" => $t['endLocation'],
                        "markers" => $t['markers'],
                        "sent" => false,
                        "startAddress" => $t->startAddress,
                        "startDate" => $t->startDate,
                        "startHour" => $t->startHour,
                        "startLocation" => $t->startLocation,
                        "status" => true,
                        "tours" => $t['tours']
                    ]);
                } else {
                    array_push($arrayTour, [
                        "id" => $t->id,
                        "idUser" => $t->user,
                        "nameUser"=> $t->nameUser,
                        "emailUser"=> $t->emailUser,
                        "endAddress" => $t->endAddress,
                        "endDate" => $t->endDate,
                        "endHour" => $t->endHour,
                        "endLocation" => $t['endLocation'],
                        "markers" => $t['markers'],
                        "sent" => false,
                        "startAddress" => $t->startAddress,
                        "startDate" => $t->startDate,
                        "startHour" => $t->startHour,
                        "startLocation" => $t->startLocation,
                        "status" => false,
                        "tours" => $t['tours']
                    ]);
                }
            }
        }
        return $arrayTour;
    }

    public function list()
    {
        $tour = Tour::where('user', '=', $this->__construct()->me()->getData()->id)
            ->orderBy('id', 'DESC')
            ->with(
                [
                    'endLocation',
                    'startLocation',
                    'markers',
                    'markers.toursLog',
                    'markers.toursLog.animal',
                    'markers.toursLog.tutor',
                    'markers.toursLog.description',
                    'markers.toursLog.endLocation',
                    'markers.toursLog.startLocation',
                    'tours',
                    'tours.animal',
                    'tours.tutor',
                    'tours.plan',
                    'tours.description',
                    'tours.endLocation',
                    'tours.startLocation',
                ])
            ->get();

        $arrayTour = array();

        foreach ($tour as $t) {
            if ($t->sent === "1") {
                if ($t->status == "1") {
                    array_push($arrayTour, [
                        "id" => $t->id,
                        "idUser" => $t->user,
                        "nameUser"=> $t->nameUser,
                        "emailUser"=> $t->emailUser,
                        "endAddress" => $t->endAddress,
                        "endDate" => $t->endDate,
                        "endHour" => $t->endHour,
                        "endLocation" => $t['endLocation'],
                        "markers" => $t['markers'],
                        "sent" => true,
                        "startAddress" => $t->startAddress,
                        "startDate" => $t->startDate,
                        "startHour" => $t->startHour,
                        "startLocation" => $t->startLocation,
                        "status" => true,
                        "tours" => $t['tours']
                    ]);
                } else {
                    array_push($arrayTour, [
                        "id" => $t->id,
                        "idUser" => $t->user,
                        "nameUser"=> $t->nameUser,
                        "emailUser"=> $t->emailUser,
                        "endAddress" => $t->endAddress,
                        "endDate" => $t->endDate,
                        "endHour" => $t->endHour,
                        "endLocation" => $t['endLocation'],
                        "markers" => $t['markers'],
                        "sent" => true,
                        "startAddress" => $t->startAddress,
                        "startDate" => $t->startDate,
                        "startHour" => $t->startHour,
                        "startLocation" => $t->startLocation,
                        "status" => false,
                        "tours" => $t['tours']
                    ]);
                }
            } else {
                if ($t->status == "1") {
                    array_push($arrayTour, [
                        "id" => $t->id,
                        "idUser" => $t->user,
                        "nameUser"=> $t->nameUser,
                        "emailUser"=> $t->emailUser,
                        "endAddress" => $t->endAddress,
                        "endDate" => $t->endDate,
                        "endHour" => $t->endHour,
                        "endLocation" => $t['endLocation'],
                        "markers" => $t['markers'],
                        "sent" => false,
                        "startAddress" => $t->startAddress,
                        "startDate" => $t->startDate,
                        "startHour" => $t->startHour,
                        "startLocation" => $t->startLocation,
                        "status" => true,
                        "tours" => $t['tours']
                    ]);
                } else {
                    array_push($arrayTour, [
                        "id" => $t->id,
                        "idUser" => $t->user,
                        "nameUser"=> $t->nameUser,
                        "emailUser"=> $t->emailUser,
                        "endAddress" => $t->endAddress,
                        "endDate" => $t->endDate,
                        "endHour" => $t->endHour,
                        "endLocation" => $t['endLocation'],
                        "markers" => $t['markers'],
                        "sent" => false,
                        "startAddress" => $t->startAddress,
                        "startDate" => $t->startDate,
                        "startHour" => $t->startHour,
                        "startLocation" => $t->startLocation,
                        "status" => false,
                        "tours" => $t['tours']
                    ]);
                }
            }
        }

        return $arrayTour;

    }
}
