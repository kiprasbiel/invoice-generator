<nav class="bg-gray-100 sm:flex-row text-right sm:justify-between py-4 px-6 sm:items-baseline w-full">
    <div>
        @if(\Request::is('register'))
            <a href="{{ route('login') }}" class="text-lg no-underline text-grey-darkest hover:text-blue-dark ml-2">Login</a>
        @elseif(\Request::is('login'))
            <a href="{{ route('register') }}" class="text-lg no-underline text-grey-darkest hover:text-blue-dark ml-2">Register</a>
        @else
            <a href="{{ route('login') }}" class="text-lg no-underline text-grey-darkest hover:text-blue-dark ml-2">Login</a>
            <a href="{{ route('register') }}" class="text-lg no-underline text-grey-darkest hover:text-blue-dark ml-2">Register</a>
        @endif
    </div>
</nav>
