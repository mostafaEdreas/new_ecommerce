<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvertNullStringToNull
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->replace($this->convertNullStrings($request->all()));
        return $next($request);
    }


    protected function convertNullStrings(array $data)
    {
        foreach ($data as $key => $value) {
            if ($value === 'null') {
                $data[$key] = null;
            } elseif (is_array($value)) {
                $data[$key] = $this->convertNullStrings($value);
            }
        }

        return $data;
    }
}
