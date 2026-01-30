<?php

namespace App\Http\Controllers;

use App\Http\Resources\Country\CountrySelectResource;
use App\Http\Resources\Level\LevelSelectResource;
use App\Http\Resources\Period\PeriodSelectResource;
use App\Http\Resources\Book\BookSelectResource;
use App\Http\Resources\Day\DaySelectResource;
use App\Http\Resources\CourseDay\CourseDaySelectResource;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use App\Repositories\StateRepository;
use App\Repositories\UserRepository;
use App\Repositories\LevelRepository;
use App\Repositories\PeriodRepository;
use App\Repositories\BookRepository;
use App\Repositories\DayRepository;
use App\Repositories\CourseDayRepository;
use App\Traits\HttpResponseTrait;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    use HttpResponseTrait;

    public function __construct(
        protected CountryRepository $countryRepository,
        protected StateRepository $stateRepository,
        protected CityRepository $cityRepository,
        protected UserRepository $userRepository,
        protected LevelRepository $levelRepository,
        protected PeriodRepository $periodRepository,
        protected BookRepository $bookRepository,
        protected DayRepository $dayRepository,
        protected CourseDayRepository $courseDayRepository,
    ) {}

    public function selectInfiniteCountries(Request $request)
    {
        return $this->execute(function () use ($request) {
            $countries = $this->countryRepository->list($request->all());

            $dataCountries = CountrySelectResource::collection($countries);

            return [
                'countries_arrayInfo' => $dataCountries,
                'countries_countLinks' => $countries->lastPage(),
            ];
        });
    }

    public function selectStates($country_id)
    {
        return $this->execute(function () use ($country_id) {
            $states = $this->stateRepository->selectList($country_id);

            return [
                'code' => 200,
                'states' => $states,
            ];
        });
    }

    public function selectCities($state_id)
    {
        return $this->execute(function () use ($state_id) {
            $cities = $this->cityRepository->selectList($state_id);

            return [
                'code' => 200,
                'cities' => $cities,
            ];
        });
    }

    public function selectCitiesCountry($country_id)
    {
        return $this->execute(function () use ($country_id) {
            $country = $this->countryRepository->find($country_id, ['cities']);

            return [
                'code' => 200,
                'message' => 'Datos Encontrados',
                'cities' => $country['cities']->map(function ($item) {
                    return [
                        'value' => $item->id,
                        'title' => $item->name,
                    ];
                }),
            ];
        });
    }

    public function selectInfiniteLevel(Request $request)
    {
        return $this->execute(function () use ($request) {
            $data = $this->levelRepository->list($request->all());
            $levels = LevelSelectResource::collection($data);

            return [
                'levels_arrayInfo' => $levels,
                'levels_countLinks' => $data->lastPage(),
            ];
        });
    }
    
    public function selectInfinitePeriod(Request $request)
    {
        return $this->execute(function () use ($request) {
            $data = $this->periodRepository->list($request->all());
            $periods = PeriodSelectResource::collection($data);

            return [
                'periods_arrayInfo' => $periods,
                'periods_countLinks' => $data->lastPage(),
            ];
        });
    }
    
    public function selectInfiniteBook(Request $request)
    {
        return $this->execute(function () use ($request) {
            $data = $this->bookRepository->list($request->all());
            $books = BookSelectResource::collection($data);

            return [
                'books_arrayInfo' => $books,
                'books_countLinks' => $data->lastPage(),
            ];
        });
    }
    
    public function selectInfiniteDay(Request $request)
    {
        return $this->execute(function () use ($request) {
            $data = $this->dayRepository->list($request->all());
            $days = DaySelectResource::collection($data);

            return [
                'days_arrayInfo' => $days,
                'days_countLinks' => $data->lastPage(),
            ];
        });
    }

    public function selectInfiniteCourseDay(Request $request)
    {
        return $this->execute(function () use ($request) {
            $data = $this->courseDayRepository->list($request->all());
            $courseDays = CourseDaySelectResource::collection($data);

            return [
                'courseDays_arrayInfo' => $courseDays,
                'courseDays_countLinks' => $data->lastPage(),
            ];
        });
    }
}
