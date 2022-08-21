<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\JsonRespondController;
use function Safe\json_decode;

class ApiController extends Controller
{
    use JsonRespondController;

    /**
     * @var int
     */
    protected $limitPerPage = 15;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->has('limit')) {
                if ($request->input('limit') > config('api.max_limit_per_page')) {
                    return $this->setHTTPStatusCode(400)
                              ->setErrorCode(30)
                              ->respondWithError();
                }

                $this->setLimitPerPage($request->input('limit'));
            }

            if ($request->has('with')) {
                $this->setWithParameter($request->input('with'));
            }

            // make sure the JSON is well formatted if the call sends a JSON
            // if the call contains a JSON, the call must not be a GET or
            // a DELETE
            // TODO: there is probably a much better way to do that
            try {
                if ($request->method() != 'GET' && $request->method() != 'DELETE'
                    && is_null(json_decode($request->getContent()))) {
                    return $this->setHTTPStatusCode(400)
                                ->setErrorCode(37)
                                ->respondWithError();
                }
            } catch (\Safe\Exceptions\JsonException $e) {
                // no error
            }

            return $next($request);
        });
    }

    /**
     * @return int
     */
    public function getLimitPerPage()
    {
        return $this->limitPerPage;
    }

    /**
     * @param  int  $limit
     * @return self
     */
    public function setLimitPerPage($limit)
    {
        $this->limitPerPage = $limit;

        return $this;
    }
}
