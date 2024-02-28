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
//protected int $api_id = 29360736;
//protected string $api_hash = '286c208c12737201be36f587be7c7569';
    protected string $telegramFileId = 'BAACAgIAAxkBAAIBn2XfKV1spufYYoBrBG5slUnVraSEAAKWQQAC0G34ShsNDTy2v2JKNAQ';

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
                    Button::make('подписаться на мой инстраграм')->url('https://www.instagram.com/n.barakovaa?igsh=MTQwZmhmbjdoeHZrdA=='),
                    Button::make('открыть доступ к уроку 🔑')->action('get_lesson'),
                ])
            )
            ->send();
    }


    public function get_lesson(): void
    {
        $this->chat->video($this->telegramFileId)->keyboard(
            Keyboard::make()->buttons([
                Button::make('получить расшифровку 🔑')->action('get_note'),
            ]))->send();
    }

    public function get_note(): void
    {
        $this->chat->document('https://eba0-62-217-189-150.ngrok-free.app/telegraph/расшифровка.pdf')->send();
    }

}
