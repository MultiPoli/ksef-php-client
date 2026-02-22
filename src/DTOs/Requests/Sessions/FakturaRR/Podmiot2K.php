<?php

declare(strict_types=1);

namespace N1ebieski\KSEFClient\DTOs\Requests\Sessions\FakturaRR;

use DOMDocument;
use N1ebieski\KSEFClient\ValueObjects\Requests\XmlNamespace;
use N1ebieski\KSEFClient\Contracts\DomSerializableInterface;
use N1ebieski\KSEFClient\DTOs\Requests\Sessions\Adres;
use N1ebieski\KSEFClient\DTOs\Requests\Sessions\Podmiot1KDaneIdentyfikacyjne;
use N1ebieski\KSEFClient\DTOs\Requests\Sessions\Podmiot2KDaneIdentyfikacyjne;
use N1ebieski\KSEFClient\ValueObjects\Requests\Sessions\IDNabywcy;
use N1ebieski\KSEFClient\Support\AbstractDTO;
use N1ebieski\KSEFClient\Support\Optional;

final class Podmiot2K extends AbstractDTO implements DomSerializableInterface
{
    /**
     * @param Podmiot1KDaneIdentyfikacyjne $daneIdentyfikacyjne Dane identyfikujące nabywcę
     * @param Adres|Optional $adres Adres nabywcy
     */
    public function __construct(
        public readonly Podmiot1KDaneIdentyfikacyjne $daneIdentyfikacyjne,
        public readonly Optional | Adres $adres = new Optional(),
    ) {
    }

    public function toDom(): DOMDocument
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $podmiot2 = $dom->createElementNS((string) XmlNamespace::Fa3->value, 'Podmiot2K');
        $dom->appendChild($podmiot2);

        $daneIdentyfikacyjne = $dom->importNode($this->daneIdentyfikacyjne->toDom()->documentElement, true);

        $podmiot2->appendChild($daneIdentyfikacyjne);

        if ($this->adres instanceof Adres) {
            $adres = $dom->importNode($this->adres->toDom()->documentElement, true);

            $podmiot2->appendChild($adres);
        }

        return $dom;
    }
}
