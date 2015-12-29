<?php

/**
 * @link https://github.com/tom--/labeler
 * @copyright Copyright (c) 2015 Spinitron, LLC
 * @license ISC https://opensource.org/licenses/ISC
 */

namespace spinitron\labeler;

use Guzzle\Http\Client;
use MusicBrainz\Filters\RecordingFilter;
use MusicBrainz\HttpAdapters\GuzzleHttpAdapter;
use MusicBrainz\MusicBrainz;
use MusicBrainz\Recording;

class Labeler
{
    public $minScore = 60;

    protected $brainz;

    public function __construct()
    {
        $this->brainz = new MusicBrainz(new GuzzleHttpAdapter(new Client()));
        $this->brainz->setUserAgent('Spinitron Labeler', '0.1', 'http://spinitron.bitbucket.com/labeler');
    }

    public static function logerr($error)
    {
        fwrite(STDERR, $error);
    }

    public static function prepare($string)
    {
        return trim(preg_replace('%[\pZ\p{Cc}]+%u', ' ', $string), ' \'"');
    }

    function cleanup($artist, $song, $album)
    {
        $answer = [static::prepare($artist), static::prepare($song), static::prepare($album), ''];

        try {
            $result = $this->brainz->search(new RecordingFilter(
                ["artist" => $artist, "recording" => $song, "release" => $album]
            ), 1);

            if (isset($result[0]->score) && $result[0]->score >= $this->minScore) {
                /** @var Recording $mbRecording */
                $mbRecording = $result[0];
                $answer[1] = $result[0]->title;

                $mbArtist = $this->brainz->lookup('artist', $mbRecording->artistID);
                if (isset($mbArtist['name'])) {
                    $answer[0] = $mbArtist['name'];
                }

                $mbRelease = $this->brainz->lookup('release', $mbRecording->releases[0]->id, ['labels']);
                if (isset($mbRelease['title'])) {
                    $answer[2] = $mbRelease['title'];
                }
                if (isset($mbRelease['label-info'][0]['label']['name'])) {
                    $answer[3] = $mbRelease['label-info'][0]['label']['name'];
                }
            }
        } catch (\Exception $e) {
            //static::logerr($e->getMessage());
        }

        return $answer;
    }
}