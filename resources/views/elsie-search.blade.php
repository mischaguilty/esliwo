<div>
    @if($elsieCredentials)
        <i class="fa fa-circle text-success"></i>
        <span>{{ __('Logged in') }}</span>
    @else
        <i class="fa fa-circle text-danger"></i>
        <a href="{{ route('login') }}">{{ __('login') }}</a>
    @endif
</div>
