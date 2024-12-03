<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvertYoutubeLinkToEmbed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('video_link')) {
            $videoLink = $request->input('video_link');
            
            // Check if the link is a YouTube link
            if (preg_match('/(?:https?:\/\/)?(?:www\.)?(youtube\.com|youtu\.be)/', $videoLink)) {
                // Extract the video ID
                preg_match('/(?:v=|\/)([a-zA-Z0-9_-]{11})/', $videoLink, $matches);

                if (isset($matches[1])) {
                    // Convert to embed link
                    $embedLink = "https://www.youtube.com/embed/" . $matches[1];
                    $request->merge(['video_link' => $embedLink]);
                }
            }
        }

        return $next($request);
    }
}
