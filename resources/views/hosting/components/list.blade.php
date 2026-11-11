@foreach ($hostings as $hosting)
    @continue((!$auth || $auth->id != $hosting->user->id) && $hosting->moderation)

    @include('hosting.components.card', ['sm' => $sm ?? false])
@endforeach
