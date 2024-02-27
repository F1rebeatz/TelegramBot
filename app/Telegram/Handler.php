<?php

namespace App\Telegram;

use DefStudio\Telegraph\Enums\ChatActions;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Stringable;

class Handler extends WebhookHandler
{
    public function handleChatMessage(Stringable $text): void
    {
        Log::info(json_encode($this->message->toArray(), JSON_UNESCAPED_UNICODE));
        $this->reply('Выберите команду в меню');
    }

    public function start(): void
    {
        $message = "С вами я - Настя!
__Эксперт в области западной астрологии__

Мои консультации меняют ваши взгляды, а обучения открывают новые возможности и повышают ваш уровень жизни 💸 🍋

Если ты новичок в области прогностической астрологии - то этот урок специально для тебя! Там я подробно рассказала о методе прогнозирования __«соляр»__

Этой информацией ты сможешь пользоваться каждый год, у неё нет срока годности! Главное, следовать всем рекомендациям, и тогда ты увидишь __первые изменения__

Приятного просмотра! 🫂

Задать интересующий вопрос можно по [ссылке](https://www.instagram.com/n.barakovaa?igsh=MTQwZmhmbjdoeHZrdA==)

        ";

        $this->chat->message($message)
            ->keyboard(
                Keyboard::make()->buttons([
                    Button::make('ПОДПИСАТЬСЯ НА МОЙ ИНСТАГРАМ')->url('https://www.instagram.com/n.barakovaa?igsh=MTQwZmhmbjdoeHZrdA=='),
                    Button::make('ОТКРЫТЬ ДОСТУП К УРОКУ 🔑')->action('get_lesson'),
                ])
            )
            ->send();
    }


    public function get_lesson(): void
    {
        $this->chat->video(Storage::path('/telegraph/IMG_9173.MOV'))->send();
    }

    public function get_note(): void
    {
        $this->chat->document(Storage::path('/telegraph/lesson.pdf'))->send();

    }

}
