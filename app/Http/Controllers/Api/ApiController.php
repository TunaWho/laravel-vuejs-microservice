<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\JsonRespondController;
use Illuminate\Support\Facades\Log;

use function Safe\json_decode;

class ApiController extends Controller
{
    use JsonRespondController;

    /**
     * @var int
     */
    protected $limitPerPage = 15;

    /**
     * It checks if the request has a limit parameter, if it does, it checks if the limit is greater
     * than the max limit per page, if it is, it returns an error. If it isn't, it sets the limit per
     * page
     */
    public function __construct()
    {
        $this->middleware(
            function ($request, $next) {
                if ($request->has('limit')) {
                    if ($request->input('limit') > config('api.max_limit_per_page')) {
                        return $this->setHttpStatusCode(400)
                            ->setErrorCode(30)
                            ->respondWithError();
                    }

                    $this->setLimitPerPage($request->input('limit'));
                }

                // Make sure the JSON is well formatted if the call sends a JSON
                // if the call contains a JSON, the call must not be a GET or
                // a DELETE.
                try {
                    if ($request->method() != 'GET'
                        && $request->method() != 'DELETE'
                        && empty(json_decode($request->getContent()))
                    ) {
                        return $this->setHttpStatusCode(400)
                            ->setErrorCode(37)
                            ->respondWithError();
                    }
                } catch (\Safe\Exceptions\JsonException $e) {
                    Log::info($e);
                }

                return $next($request);
            }
        );
    }

    /**
     * @return int
     */
    public function getLimitPerPage()
    {
        return $this->limitPerPage;
    }

    /**
     * @param  int  $limit The number of items to return.
     * @return self
     */
    public function setLimitPerPage($limit)
    {
        $this->limitPerPage = $limit;

        return $this;
    }
}
