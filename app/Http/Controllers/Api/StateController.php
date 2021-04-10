<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\Contracts\StateRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Support\Facades\Cache;

class StateController extends Controller
{
    private $stateRepository;

    public function __construct(StateRepositoryInterface $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

     /**
     * Function list states.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        try {
            $data = Cache::remember('all-states', now()->addMinute(60), function () {
                return $this->stateRepository->get(['id','name','initials']);
            });

            return response()->json(['success' => true, 'data' => $data], 200);

        } catch(ModelNotFoundException $e) {
            return response()->json('Not Found',404);
        } catch(\Exception $e) {
            info($e);
            return response()->json(['success' => false, 'data' => 'Error listing States'], 500);
        }
    }
}
