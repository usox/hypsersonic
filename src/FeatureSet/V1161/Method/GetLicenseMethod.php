<?php

declare(strict_types=1);

namespace Usox\HyperSonic\FeatureSet\V1161\Method;

use Usox\HyperSonic\FeatureSet\V1161\Contract\LicenseDataProviderInterface;
use Usox\HyperSonic\FeatureSet\V1161\Responder\ResponderFactoryInterface;
use Usox\HyperSonic\Response\ResponderInterface;
use Usox\HyperSonic\Response\ResponseWriterInterface;

final class GetLicenseMethod implements V1161MethodInterface
{
    public function __construct(
        private readonly ResponderFactoryInterface $responderFactory,
    ) {
    }

    /**
     * @param array<string, scalar> $args
     */
    public function __invoke(
        ResponseWriterInterface $responseWriter,
        LicenseDataProviderInterface $licenseDataProvider,
        array $args
    ): ResponderInterface {
        return $this->responderFactory->createLicenseResponder([
            'valid' => $licenseDataProvider->isValid() ? 'true' : 'false',
            'email' => $licenseDataProvider->getEmailAddress(),
            'licenseExpires' => $licenseDataProvider->getExpiryDate()->format(DATE_ATOM),
        ]);
    }
}
