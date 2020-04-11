<nav class="bg-blue-900 shadow mb-8 py-6">
    <div class="container mx-auto px-6 md:px-0">
        <div class="flex items-center justify-center">
            <div class="mr-6">
                <a href="/home" class="text-lg font-semibold text-gray-100 no-underline">
                    Home
                </a>
                <a href="/products" class="text-lg font-semibold text-gray-100 no-underline">
                    Products
                </a>
                    <a href="/orders" class="text-lg font-semibold text-gray-100 no-underline">
                    Orders
                </a>
                <a href="/stocktakes" class="text-lg font-semibold text-gray-100 no-underline">
                    Stocktakes
                </a>
                <a href="/poh" class="text-lg font-semibold text-gray-100 no-underline">
                    History
                </a>
            </div>

            <div class="flex-1 text-right">
                @guest
                    <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                    @if (Route::has('register'))
                        <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                @else
                    <span class="text-gray-300 text-sm pr-4">{{ Auth::user()->name }}</span>

                    <a href="{{ route('logout') }}"
                        class="no-underline hover:underline text-gray-300 text-sm p-3"
                        onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        {{ csrf_field() }}
                    </form>
                @endguest
            </div>
        </div>
    </div>
</nav>
