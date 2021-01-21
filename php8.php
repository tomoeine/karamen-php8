<?php

class Karamen
{
    /* Constructor Property Promotion */
    /* Union Types */
    public function __construct(
        private int $karasa,
        private bool $nira,
        private bool $ninniku,
        private string|array|null $toppings = null)
    {
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
        /* Match expression */
        return match (true) {
            $this->karasa < 10 => 'mild',
            $this->karasa < 20 => 'karai',
            $this->karasa < 30 => 'gekikara',
            $this->karasa < 40 => 'chokara',
            default => 'yabai',
        };
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

        /* Match expression */
        $result = match ($karamen->roughKarasa()) {
            'mild' => 'そんなに辛くないよ！',
            'karai' => 'ちょっと辛いよ！',
            'gekikara' => '結構辛いよ！',
            'chokara' => 'かなり辛いから気をつけて！',
            default => 'ヤバいから心して食え',
        };
        echo $result;
    }
}

$server = new Server();

/* Named arguments */
$karamen = new Karamen(ninniku: true, karasa: 3, nira: true, toppings: ['なんこつ', 'ねぎ']);
$server->serve($karamen);

echo "\n";

/* Named arguments */
$karamen = new Karamen(ninniku: true, karasa: 40, nira: true);
$server->serve($karamen);