<?php
namespace MI;

// includes the autoloader for libraries installed with composer
require __DIR__ . '../vendor/autoload.php';


// Imports the Cloud Client Library
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;


class GoogleTTS
{
    public function saveMp3FileSystem($text = 'Hello, world!', $filename = 'output.mp3'): void
    {
        file_put_contents($filename, self::downloadMP3($text));
    }

    public function saveMp3HTTP($text = 'Hello, world!', $filename = 'output.mp3'): void
    {
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo self::downloadMP3($text);
    }

    public function saveMp3Raw($text = 'Hello, world!'): string
    {
        return self::downloadMP3($text);
    }

    public $voice;

    public function __construct()
    {
        $this->voice =
            (new VoiceSelectionParams())
            ->setLanguageCode('en-GB')
            ->setSsmlGender(SsmlVoiceGender::FEMALE)
            ->setName('en-GB-Wavenet-A');
    }

    private function downloadMP3($text = 'Hello, world!'): string
    {
        // instantiates a client
        $client = new TextToSpeechClient();

        // sets text to be synthesised
        $synthesisInputText = (new SynthesisInput())
            ->setText($text);

        // Effects profile
        $effectsProfileId = "headphone-class-device";

        // select the type of audio file you want returned
        $audioConfig = (new AudioConfig())
            ->setAudioEncoding(AudioEncoding::MP3)
            ->setEffectsProfileId(array($effectsProfileId));

        // perform text-to-speech request on the text input with selected voice
        // parameters and audio file type
        $response = $client->synthesizeSpeech($synthesisInputText, $this->voice, $audioConfig);
        $audioContent = $response->getAudioContent();

        return $audioContent;
    }
}
