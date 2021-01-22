<?php

class Karamen
{
    private int $karasa;
    private bool $nira;
    private bool $ninniku;
    private mixed $toppings;

    public function __construct(
        int $karasa,
        bool $nira,
        bool $ninniku,
        mixed $toppings = null)
    {
        $this->karasa = $karasa;
        $this->nira = $nira;
        $this->ninniku = $ninniku;
        $this->toppings = $toppings;
    }

    public function description(): array
    {
        $description = [];
        $description[] = $this->nira ? 'ニラあり' : 'ニラなし';
        $description[] = $this->ninniku ? 'ニンニクあり' : 'ニンニクなし';
        if ($this->toppingStr()) {
            $description[] =  $this->toppingStr() . 'トッピング';
        }
        
        return $description;
    }

    /**
     * トッピングを文字列にして返す
     * @return string
     */
    public function toppingStr(): string
    {
        if (is_array($this->toppings)) {
            return implode('と', $this->toppings);
        }
        return $this->toppings ?? '';
    }

    /**
     * 辛さを大雑把に返す
     * @return string
     */
    public function roughKarasa(): string
    {
        switch (true) {
            case $this->karasa < 10:
                $result = 'mild';
                break;
            case $this->karasa < 20:
                $result = 'karai';
                break;
            case $this->karasa < 30:
                $result = 'gekikara';
                break;
            case $this->karasa < 40:
                $result = 'chokara';
                break;
            default:
                $result = 'yabai';
        }
        return $result;
    }
}

class Server
{
    /**
     * 指定された辛麺を提供する（喋るだけ）
     * @param Karamen $karamen
     */
    public function serve(Karamen $karamen): void
    {
        echo 'お待ち！';
        echo implode('、', $karamen->description());
        echo '、';

        switch ($karamen->roughKarasa()) {
            case 'mild':
                $result = 'そんなに辛くないよ！';
                break;
            case 'karai':
                $result = 'ちょっと辛いよ！';
                break;
            case 'gekikara':
                $result = '結構辛いよ！';
                break;
            case 'chokara':
                $result = 'かなり辛いから気をつけて！';
                break;
            case 'yabai':
                $result = 'ヤバいから心して食え';
                break;
            default:
                $result = '';
        };
        echo $result;
    }
}

$server = new Server();

$karamen = new Karamen(3, true, true, ['なんこつ', 'ねぎ']);
$server->serve($karamen);

echo "\n";

$karamen = new Karamen(40, true, false);
$server->serve($karamen);