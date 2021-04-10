<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\Contracts\StateRepositoryInterface;

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
            
            $data = $this->stateRepository->get(['id','name','initials']);
            return response()->json(['success' => true, 'data' => $data], 200);

        } catch(\Exception $e) {
            info($e);
            return response()->json(['success' => false, 'data' => 'Error listing States'], 500);
        }
    }
}
