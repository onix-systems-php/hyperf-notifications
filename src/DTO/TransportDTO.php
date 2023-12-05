<?php

namespace OnixSystemsPHP\HyperfNotifications\DTO;

use OnixSystemsPHP\HyperfCore\DTO\AbstractDTO;

class TransportDTO extends AbstractDTO
{
    public string $type;

    public string $transport;

    public ?array $options;
}
