<!-- Section 1 -->
<footer class="@if(Request::is('/')){{ 'bg-black' }}@else{{ 'bg-black' }}@endif">
    <div class="px-8 pt-16 mx-auto lg:px-12 xl:px-16 max-w-7xl">
        <div class="flex flex-wrap items-start justify-between pb-20">
            <a href="" class="flex items-center w-auto text-lg font-bold md:w-1/6">
                @if(Voyager::image(theme('footer_logo')))
                <img class="h-32" src="{{ Voyager::image(theme('footer_logo')) }}" alt="Company name">
                @else
                <div class="relative flex items-center text-gray-500 leading-tighter">
                    <svg class="h-8 mt-1 fill-current" viewBox="0 0 164 145" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M161.47 45.02c-.22-1-.46-2-.72-3v-.28l-.19-.27-.18-.66h-.14c-2.69-7.59-9.38-11.76-18.95-11.76-14.1 0-33.18 9-51.05 24.2l-2.3 2c-18.72-8.37-27.87-24.27-35.26-37.1C46.86 8.03 42.26.04 34.68.04c-3.8 0-7.73 2.05-12.29 6.39-.15.14-15.84 15.85-21.08 41.81a76.56 76.56 0 001.13 33.75v.19c.06.26.12.52.2.78v.16c.54 2.08 1.2 4.21 2 6.35l.25.69a81.55 81.55 0 00130.26 33.92l.75-.59v-.08a81.73 81.73 0 0025.51-43.44c.24-1.11.46-2.24.66-3.36a83.42 83.42 0 001.08-8.83 80.61 80.61 0 00-1.68-22.76zm-67.95 12c17-14.4 34.86-23 47.81-23 7.5 0 12.3 2.85 14.26 8.48l-.07.42.24.34c.06.46.08.91.11 1.36V46.9c0 .57-.09 1.12-.17 1.66v.25c-.08.46-.16.92-.28 1.36-.12.44-.23.74-.35 1.1-.05.14-.08.28-.14.41a13.28 13.28 0 01-2.42 4c-4.47 5.18-13.39 8-25.13 8-1.22 0-2.46 0-3.72-.1h-.46c-1.2-.06-2.42-.16-3.65-.28l-.64-.06c-1.21-.13-2.44-.28-3.68-.46l-.64-.1c-1.27-.19-2.53-.4-3.81-.64l-.47-.09c-1.31-.26-2.63-.53-4-.84h-.11c-1.33-.31-2.66-.65-4-1l-.54-.15c-1.28-.35-2.55-.73-3.81-1.13l-.67-.21c-1.25-.41-2.49-.83-3.73-1.28l-.26-.09.33-.23zM5.26 68.34a67.54 67.54 0 011-19.13 83.46 83.46 0 0119.57-39.12c3.53-3.36 6.53-5.07 8.9-5.07 4.67 0 8.63 6.89 13.65 15.6C55.46 32.93 65 49.51 83.79 58.79l-.14.12-.77.66c-9.74 8.39-20.7 17.82-31.24 25.22C43.55 69.34 32.39 60.48 21 60.48a19.21 19.21 0 00-15.12 7c-.19.26-.41.55-.62.86zm4.42 20.08c-.8-2.19-1.48-4.37-2-6.5l-.06-.25a5.18 5.18 0 01-.14-.53v-.2c-.06-.25-.09-.5-.13-.75-.04-.25-.08-.46-.1-.69-.02-.23 0-.48 0-.72v-.64-.73-.62c0-.2.08-.47.12-.7.04-.23.07-.42.12-.63.05-.21.12-.43.19-.65.07-.22.11-.43.19-.64.08-.21.16-.38.24-.57.08-.19.18-.45.29-.67.11-.22.17-.31.26-.47.09-.16.26-.49.41-.72a.86.86 0 01.07-.1c.23-.346.476-.68.74-1a14.22 14.22 0 0111.22-5.13c9.49 0 19.07 7.93 26.27 21.74l.21.39c-10.5 6.88-18.71 10.24-25 10.24-5.99-.05-10.18-3.14-12.9-9.48v.02zm72.1 50.66a76.7 76.7 0 01-13.33-1.17c-1.24-.22-2.46-.47-3.68-.75l-.7-.16c-1.17-.28-2.33-.58-3.49-.92l-.65-.19c-1.14-.34-2.27-.7-3.38-1.09l-.19-.06a83.04 83.04 0 01-3.42-1.31l-.67-.28c-1.1-.46-2.19-.94-3.26-1.45l-.55-.27c-1-.5-2.07-1-3.08-1.58-.09-.05-.19-.09-.28-.15-1.06-.58-2.1-1.19-3.13-1.81l-.61-.38c-1-.63-2-1.28-3-2l-.43-.3c-.94-.66-1.86-1.33-2.77-2-.1-.09-.22-.17-.32-.25-.947-.74-1.877-1.5-2.79-2.28l-.54-.46c-.9-.79-1.79-1.59-2.66-2.42l-.31-.31c-.82-.79-1.63-1.6-2.42-2.44l-.34-.35a76.17 76.17 0 01-2.38-2.69l-.46-.54c-.78-.93-1.53-1.87-2.27-2.83l-.2-.28c-.7-.92-1.37-1.87-2-2.82l-.33-.48c-.66-1-1.31-2-1.93-3l-.16-.27c8.08 2.92 19.11-.15 33.93-9.8.45.75.91 1.5 1.39 2.24l.33.5c.37.56.74 1.13 1.12 1.68l.53.75c.32.47.65.93 1 1.39l.63.83.94 1.26c.23.29.46.57.68.86l.94 1.17.73.87.95 1.12c.25.29.51.57.77.86l1 1.07.8.85 1 1 .83.83 1 1 .22.21c.082.088.169.172.26.25l.36.34 1 .91.94.85.94.83 1 .86c.3.25.6.51.91.75l1.06.86.89.7 1.12.85.85.63 1.18.84.83.58c.4.28.81.55 1.22.82l.81.52c.42.28.84.54 1.26.8l.79.48 1.31.77.76.44 1.35.74.74.39 1.38.7.72.35 1.42.67.7.31 1.45.62c.22.1.45.18.67.27l1.49.59.64.23c.51.19 1 .37 1.52.54l.61.2 1.55.48.58.17c.53.15 1.06.3 1.59.43l.53.13c.55.13 1.09.27 1.64.38l.47.1c.56.11 1.12.23 1.69.32.12 0 .25 0 .37.06.59.1 1.19.2 1.78.28h.21a49.06 49.06 0 006.14.4c.79 0 1.57 0 2.34-.07h.29a76.19 76.19 0 01-32.42 7.21v.02zm75.37-63.34c-.19 1.07-.4 2.14-.64 3.2a76.65 76.65 0 01-24.5 41.23l-.08.06c-.45.35-.91.66-1.37 1l-.6.4-.44.3c-.39.25-.8.48-1.2.71l-.79.45-.28.15c-.42.22-.85.42-1.28.62-.43.2-.73.35-1.11.5-.38.15-.9.35-1.36.52-.46.17-.74.28-1.12.4-.38.12-1 .28-1.46.41-.46.13-.75.22-1.13.3-.38.08-1.06.22-1.59.31-.37.07-.72.15-1.09.21-.61.09-1.23.14-1.84.2l-.95.11c-.94.06-1.9.1-2.87.1-.66 0-1.32 0-2-.05h-.65l-1.34-.09-.79-.09-1.21-.14-.84-.13-1.17-.19-.88-.17-1.13-.23-.9-.22c-.37-.09-.75-.17-1.12-.27l-.91-.25-1.11-.32-.92-.3c-.37-.11-.74-.23-1.1-.36-.36-.13-.61-.21-.92-.33l-1.1-.4-.91-.36-1.1-.45-.91-.4-1.1-.49-.9-.43-1.09-.54-.9-.46-1.08-.58-.89-.49-1.07-.62-.89-.53-1.06-.65-.87-.56-1.05-.69-.87-.59-1-.73-.85-.61-1-.77-.84-.65-1-.8c-.28-.22-.56-.44-.83-.67l-1-.84-.82-.7-.81-.72-.17-.15-.78-.72-1-.94-.72-.69-1-1-.66-.67-1.06-1.12-.58-.63-1.1-1.23-.5-.57c-.39-.45-.78-.91-1.16-1.37-.13-.16-.27-.32-.4-.49-.41-.5-.81-1-1.21-1.52l-.31-.38c-.43-.56-.85-1.13-1.27-1.7l-.19-.26c-.47-.64-.92-1.29-1.37-1.94v-.06c-.34-.49-.66-1-1-1.47-.48-.73-.95-1.47-1.4-2.22-.15-.24-.3-.47-.44-.71 10.87-7.59 22.09-17.24 32.06-25.82l2.71-2.33c12.69 5.09 26.26 7.89 38.38 7.89 13.42 0 23.45-3.39 29-9.81a18.24 18.24 0 001.27-1.66l.18-.26c.14-.22.3-.43.43-.65a76.24 76.24 0 01-1.08 19.17z"
                            fill-rule="nonzero" />
                    </svg>
                    <span class="ml-4 text-3xl font-thin tracking-wide"></span>
                </div>
                @endif
            </a>
            <div class="grid w-full grid-cols-2 pt-2 mt-20 sm:grid-cols-4 gap-y-16 lg:gap-x-8 md:w-5/6 md:mt-0 md:pr-6">
                <div class="md:justify-self-end">
                    <h3 class="font-semibold text-white">Productos</h3>
                    <ul class="mt-6 space-y-4 text-sm">
                        <li>
                            <a href="" class="relative inline-block text-black group">
                                <span
                                    class="absolute bottom-0 w-full transition duration-150 ease-out transform -translate-y-1 border-b border-black opacity-0 group-hover:opacity-100 group-hover:translate-y-1"></span>
                                <span class="text-white">Vitrix.io ¿Qué Somos?</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('inversion')}}" class="relative inline-block text-black group">
                                <span
                                    class="absolute bottom-0 w-full transition duration-150 ease-out transform -translate-y-1 border-b border-black opacity-0 group-hover:opacity-100 group-hover:translate-y-1"></span>
                                <span class="text-white">Inversión</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('referidos_informacion')}}" class="relative inline-block text-black group">
                                <span
                                    class="absolute bottom-0 w-full transition duration-150 ease-out transform -translate-y-1 border-b border-black opacity-0 group-hover:opacity-100 group-hover:translate-y-1"></span>
                                <span class="text-white">Referidos</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="md:justify-self-end">
                    <h3 class="font-semibold text-white">Sobre Nosotros</h3>
                    <ul class="mt-6 space-y-4 text-sm">
                        <li>
                            <a href="{{route('historia')}}" class="relative inline-block text-black group">
                                <span
                                    class="absolute bottom-0 w-full transition duration-150 ease-out transform -translate-y-1 border-b border-black opacity-0 group-hover:opacity-100 group-hover:translate-y-1"></span>
                                <span class="text-white">Nuestra Historia</span>
                            </a>
                        </li>



                    </ul>
                </div>
                <div class="md:justify-self-end">
                    <h3 class="font-semibold text-white">Recursos</h3>
                    <ul class="mt-6 space-y-4 text-sm">
                        <li>
                            <a href="{{route('ayuda')}}" class="relative inline-block text-black group">
                                <span
                                    class="absolute bottom-0 w-full transition duration-150 ease-out transform -translate-y-1 border-b border-black opacity-0 group-hover:opacity-100 group-hover:translate-y-1"></span>
                                <span class="text-white">Centro de ayuda</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('noticias')}}" class="relative inline-block text-black group">
                                <span
                                    class="absolute bottom-0 w-full transition duration-150 ease-out transform -translate-y-1 border-b border-black opacity-0 group-hover:opacity-100 group-hover:translate-y-1"></span>
                                <span class="text-white">Noticias</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('preguntas')}}" class="relative inline-block text-black group">
                                <span
                                    class="absolute bottom-0 w-full transition duration-150 ease-out transform -translate-y-1 border-b border-black opacity-0 group-hover:opacity-100 group-hover:translate-y-1"></span>
                                <span class="text-white">Preguntas Frecuentes</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('sitemap')}}" class="relative inline-block text-black group">
                                <span
                                    class="absolute bottom-0 w-full transition duration-150 ease-out transform -translate-y-1 border-b border-black opacity-0 group-hover:opacity-100 group-hover:translate-y-1"></span>
                                <span class="text-white">Sitemap</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="md:justify-self-end">
                    <h3 class="font-semibold text-white">Contactos</h3>
                    <ul class="mt-6 space-y-4 text-sm">
                        <li>
                            <a href="{{route('contactanos')}}" class="relative inline-block text-black group">
                                <span
                                    class="absolute bottom-0 w-full transition duration-150 ease-out transform -translate-y-1 border-b border-black opacity-0 group-hover:opacity-100 group-hover:translate-y-1"></span>
                                <span class="text-white">Contactanos</span>
                            </a>
                        </li>


                    </ul>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-center justify-between py-10 border-t border-solid lg:flex-row border-gray">
            <ul class="flex flex-wrap space-x-5 text-xs">
                <li class="mb-6 text-center flex-full lg:flex-none lg:mb-0 text-white">&copy; {{ date('Y') }} {{
                    setting('site.title', 'Laravel Wave') }}, Inc. All rights reserved.</li>
                <li class="lg:ml-6">
                    <a href="{{route('privacidad')}}" class="relative inline-block text-black group">
                        <span
                            class="absolute bottom-0 w-full transition duration-150 ease-out transform -translate-y-1 border-b border-black opacity-0 group-hover:opacity-100 group-hover:translate-y-0"></span>
                        <span class="text-white">Politicas de privacidad</span>
                    </a>
                </li>

                <li class="lg:ml-6">
                    <a href="{{route('terminos')}}" class="relative inline-block text-black group">
                        <span
                            class="absolute bottom-0 w-full transition duration-150 ease-out transform -translate-y-1 border-b border-black opacity-0 group-hover:opacity-100 group-hover:translate-y-0"></span>
                        <span class="text-white">Terminos y Condiciones</span>
                    </a>
                </li>
            </ul>

            <ul class="flex items-center mt-10 space-x-5 lg:mt-0">
                <li>
                    <a href="#" class="text-gray-600 hover:text-gray-900" target="_blank" rel="noopener noreferrer">
                        <span class="sr-only">Facebook</span>
                     <svg width="35px" height="35px" viewBox="126.445 2.281 589 589" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><circle cx="420.945" cy="296.781" r="294.5" fill="#3c5a9a"></circle><path d="M516.704 92.677h-65.239c-38.715 0-81.777 16.283-81.777 72.402.189 19.554 0 38.281 0 59.357H324.9v71.271h46.174v205.177h84.847V294.353h56.002l5.067-70.117h-62.531s.14-31.191 0-40.249c0-22.177 23.076-20.907 24.464-20.907 10.981 0 32.332.032 37.813 0V92.677h-.032z" fill="#ffffff"></path></g></svg>
                    </a>
                </li>
                <li>

                    <a href="https://www.instagram.com/vitrix.game?igsh=MWR3aXdpdXpuYzU1cg=="
                        class="text-gray-600 hover:text-gray-900" target="_blank" rel="noopener noreferrer">
                        <span class="sr-only">Instagram</span>
                        <svg width="35px" height="35px" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect x="2" y="2" width="28" height="28" rx="6" fill="url(#paint0_radial_87_7153)"></rect> <rect x="2" y="2" width="28" height="28" rx="6" fill="url(#paint1_radial_87_7153)"></rect> <rect x="2" y="2" width="28" height="28" rx="6" fill="url(#paint2_radial_87_7153)"></rect> <path d="M23 10.5C23 11.3284 22.3284 12 21.5 12C20.6716 12 20 11.3284 20 10.5C20 9.67157 20.6716 9 21.5 9C22.3284 9 23 9.67157 23 10.5Z" fill="white"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M16 21C18.7614 21 21 18.7614 21 16C21 13.2386 18.7614 11 16 11C13.2386 11 11 13.2386 11 16C11 18.7614 13.2386 21 16 21ZM16 19C17.6569 19 19 17.6569 19 16C19 14.3431 17.6569 13 16 13C14.3431 13 13 14.3431 13 16C13 17.6569 14.3431 19 16 19Z" fill="white"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M6 15.6C6 12.2397 6 10.5595 6.65396 9.27606C7.2292 8.14708 8.14708 7.2292 9.27606 6.65396C10.5595 6 12.2397 6 15.6 6H16.4C19.7603 6 21.4405 6 22.7239 6.65396C23.8529 7.2292 24.7708 8.14708 25.346 9.27606C26 10.5595 26 12.2397 26 15.6V16.4C26 19.7603 26 21.4405 25.346 22.7239C24.7708 23.8529 23.8529 24.7708 22.7239 25.346C21.4405 26 19.7603 26 16.4 26H15.6C12.2397 26 10.5595 26 9.27606 25.346C8.14708 24.7708 7.2292 23.8529 6.65396 22.7239C6 21.4405 6 19.7603 6 16.4V15.6ZM15.6 8H16.4C18.1132 8 19.2777 8.00156 20.1779 8.0751C21.0548 8.14674 21.5032 8.27659 21.816 8.43597C22.5686 8.81947 23.1805 9.43139 23.564 10.184C23.7234 10.4968 23.8533 10.9452 23.9249 11.8221C23.9984 12.7223 24 13.8868 24 15.6V16.4C24 18.1132 23.9984 19.2777 23.9249 20.1779C23.8533 21.0548 23.7234 21.5032 23.564 21.816C23.1805 22.5686 22.5686 23.1805 21.816 23.564C21.5032 23.7234 21.0548 23.8533 20.1779 23.9249C19.2777 23.9984 18.1132 24 16.4 24H15.6C13.8868 24 12.7223 23.9984 11.8221 23.9249C10.9452 23.8533 10.4968 23.7234 10.184 23.564C9.43139 23.1805 8.81947 22.5686 8.43597 21.816C8.27659 21.5032 8.14674 21.0548 8.0751 20.1779C8.00156 19.2777 8 18.1132 8 16.4V15.6C8 13.8868 8.00156 12.7223 8.0751 11.8221C8.14674 10.9452 8.27659 10.4968 8.43597 10.184C8.81947 9.43139 9.43139 8.81947 10.184 8.43597C10.4968 8.27659 10.9452 8.14674 11.8221 8.0751C12.7223 8.00156 13.8868 8 15.6 8Z" fill="white"></path> <defs> <radialGradient id="paint0_radial_87_7153" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(12 23) rotate(-55.3758) scale(25.5196)"> <stop stop-color="#B13589"></stop> <stop offset="0.79309" stop-color="#C62F94"></stop> <stop offset="1" stop-color="#8A3AC8"></stop> </radialGradient> <radialGradient id="paint1_radial_87_7153" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(11 31) rotate(-65.1363) scale(22.5942)"> <stop stop-color="#E0E8B7"></stop> <stop offset="0.444662" stop-color="#FB8A2E"></stop> <stop offset="0.71474" stop-color="#E2425C"></stop> <stop offset="1" stop-color="#E2425C" stop-opacity="0"></stop> </radialGradient> <radialGradient id="paint2_radial_87_7153" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(0.500002 3) rotate(-8.1301) scale(38.8909 8.31836)"> <stop offset="0.156701" stop-color="#406ADC"></stop> <stop offset="0.467799" stop-color="#6A45BE"></stop> <stop offset="1" stop-color="#6A45BE" stop-opacity="0"></stop> </radialGradient> </defs> </g></svg>
                    </a>
                </li>
                <li>
                    <a href="https://www.tiktok.com/@vitrix.game?_t=ZS-8x4V6oxouLh&_r=1" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-gray-900">
                        <span class="sr-only">Tiktok</span>
                       <svg width="35px" height="35px" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M8.45095 19.7926C8.60723 18.4987 9.1379 17.7743 10.1379 17.0317C11.5688 16.0259 13.3561 16.5948 13.3561 16.5948V13.2197C13.7907 13.2085 14.2254 13.2343 14.6551 13.2966V17.6401C14.6551 17.6401 12.8683 17.0712 11.4375 18.0775C10.438 18.8196 9.90623 19.5446 9.7505 20.8385C9.74562 21.5411 9.87747 22.4595 10.4847 23.2536C10.3345 23.1766 10.1815 23.0889 10.0256 22.9905C8.68807 22.0923 8.44444 20.7449 8.45095 19.7926ZM22.0352 6.97898C21.0509 5.90039 20.6786 4.81139 20.5441 4.04639H21.7823C21.7823 4.04639 21.5354 6.05224 23.3347 8.02482L23.3597 8.05134C22.8747 7.7463 22.43 7.38624 22.0352 6.97898ZM28 10.0369V14.293C28 14.293 26.42 14.2312 25.2507 13.9337C23.6179 13.5176 22.5685 12.8795 22.5685 12.8795C22.5685 12.8795 21.8436 12.4245 21.785 12.3928V21.1817C21.785 21.6711 21.651 22.8932 21.2424 23.9125C20.709 25.246 19.8859 26.1212 19.7345 26.3001C19.7345 26.3001 18.7334 27.4832 16.9672 28.28C15.3752 28.9987 13.9774 28.9805 13.5596 28.9987C13.5596 28.9987 11.1434 29.0944 8.96915 27.6814C8.49898 27.3699 8.06011 27.0172 7.6582 26.6277L7.66906 26.6355C9.84383 28.0485 12.2595 27.9528 12.2595 27.9528C12.6779 27.9346 14.0756 27.9528 15.6671 27.2341C17.4317 26.4374 18.4344 25.2543 18.4344 25.2543C18.5842 25.0754 19.4111 24.2001 19.9423 22.8662C20.3498 21.8474 20.4849 20.6247 20.4849 20.1354V11.3475C20.5435 11.3797 21.2679 11.8347 21.2679 11.8347C21.2679 11.8347 22.3179 12.4734 23.9506 12.8889C25.1204 13.1864 26.7 13.2483 26.7 13.2483V9.91314C27.2404 10.0343 27.7011 10.0671 28 10.0369Z" fill="#EE1D52"></path> <path d="M26.7009 9.91314V13.2472C26.7009 13.2472 25.1213 13.1853 23.9515 12.8879C22.3188 12.4718 21.2688 11.8337 21.2688 11.8337C21.2688 11.8337 20.5444 11.3787 20.4858 11.3464V20.1364C20.4858 20.6258 20.3518 21.8484 19.9432 22.8672C19.4098 24.2012 18.5867 25.0764 18.4353 25.2553C18.4353 25.2553 17.4337 26.4384 15.668 27.2352C14.0765 27.9539 12.6788 27.9357 12.2604 27.9539C12.2604 27.9539 9.84473 28.0496 7.66995 26.6366L7.6591 26.6288C7.42949 26.4064 7.21336 26.1717 7.01177 25.9257C6.31777 25.0795 5.89237 24.0789 5.78547 23.7934C5.78529 23.7922 5.78529 23.791 5.78547 23.7898C5.61347 23.2937 5.25209 22.1022 5.30147 20.9482C5.38883 18.9122 6.10507 17.6625 6.29444 17.3494C6.79597 16.4957 7.44828 15.7318 8.22233 15.0919C8.90538 14.5396 9.6796 14.1002 10.5132 13.7917C11.4144 13.4295 12.3794 13.2353 13.3565 13.2197V16.5948C13.3565 16.5948 11.5691 16.028 10.1388 17.0317C9.13879 17.7743 8.60812 18.4987 8.45185 19.7926C8.44534 20.7449 8.68897 22.0923 10.0254 22.991C10.1813 23.0898 10.3343 23.1775 10.4845 23.2541C10.7179 23.5576 11.0021 23.8221 11.3255 24.0368C12.631 24.8632 13.7249 24.9209 15.1238 24.3842C16.0565 24.0254 16.7586 23.2167 17.0842 22.3206C17.2888 21.7611 17.2861 21.1978 17.2861 20.6154V4.04639H20.5417C20.6763 4.81139 21.0485 5.90039 22.0328 6.97898C22.4276 7.38624 22.8724 7.7463 23.3573 8.05134C23.5006 8.19955 24.2331 8.93231 25.1734 9.38216C25.6596 9.61469 26.1722 9.79285 26.7009 9.91314Z" fill="#000000"></path> <path d="M4.48926 22.7568V22.7594L4.57004 22.9784C4.56076 22.9529 4.53074 22.8754 4.48926 22.7568Z" fill="#69C9D0"></path> <path d="M10.5128 13.7916C9.67919 14.1002 8.90498 14.5396 8.22192 15.0918C7.44763 15.7332 6.79548 16.4987 6.29458 17.354C6.10521 17.6661 5.38897 18.9168 5.30161 20.9528C5.25223 22.1068 5.61361 23.2983 5.78561 23.7944C5.78543 23.7956 5.78543 23.7968 5.78561 23.798C5.89413 24.081 6.31791 25.0815 7.01191 25.9303C7.2135 26.1763 7.42963 26.4111 7.65924 26.6334C6.92357 26.1457 6.26746 25.5562 5.71236 24.8839C5.02433 24.0451 4.60001 23.0549 4.48932 22.7626C4.48919 22.7605 4.48919 22.7584 4.48932 22.7564V22.7527C4.31677 22.2571 3.95431 21.0651 4.00477 19.9096C4.09213 17.8736 4.80838 16.6239 4.99775 16.3108C5.4985 15.4553 6.15067 14.6898 6.92509 14.0486C7.608 13.4961 8.38225 13.0567 9.21598 12.7484C9.73602 12.5416 10.2778 12.3891 10.8319 12.2934C11.6669 12.1537 12.5198 12.1415 13.3588 12.2575V13.2196C12.3808 13.2349 11.4148 13.4291 10.5128 13.7916Z" fill="#69C9D0"></path> <path d="M20.5438 4.04635H17.2881V20.6159C17.2881 21.1983 17.2881 21.76 17.0863 22.3211C16.7575 23.2167 16.058 24.0253 15.1258 24.3842C13.7265 24.923 12.6326 24.8632 11.3276 24.0368C11.0036 23.823 10.7187 23.5594 10.4844 23.2567C11.5962 23.8251 12.5913 23.8152 13.8241 23.341C14.7558 22.9821 15.4563 22.1734 15.784 21.2774C15.9891 20.7178 15.9864 20.1546 15.9864 19.5726V3H20.4819C20.4819 3 20.4315 3.41188 20.5438 4.04635ZM26.7002 8.99104V9.9131C26.1725 9.79263 25.6609 9.61447 25.1755 9.38213C24.2352 8.93228 23.5026 8.19952 23.3594 8.0513C23.5256 8.1559 23.6981 8.25106 23.8759 8.33629C25.0192 8.88339 26.1451 9.04669 26.7002 8.99104Z" fill="#69C9D0"></path> </g></svg>
                    </a>
                </li>
                <li>
                    <a href="https://m.youtube.com/@vitrixgame" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-gray-900">
                        <span class="sr-only">Youtube</span>
                       <svg width="35px" height="35px" viewBox="0 -7 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>Youtube-color</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Color-" transform="translate(-200.000000, -368.000000)" fill="#CE1312"> <path d="M219.044,391.269916 L219.0425,377.687742 L232.0115,384.502244 L219.044,391.269916 Z M247.52,375.334163 C247.52,375.334163 247.0505,372.003199 245.612,370.536366 C243.7865,368.610299 241.7405,368.601235 240.803,368.489448 C234.086,368 224.0105,368 224.0105,368 L223.9895,368 C223.9895,368 213.914,368 207.197,368.489448 C206.258,368.601235 204.2135,368.610299 202.3865,370.536366 C200.948,372.003199 200.48,375.334163 200.48,375.334163 C200.48,375.334163 200,379.246723 200,383.157773 L200,386.82561 C200,390.73817 200.48,394.64922 200.48,394.64922 C200.48,394.64922 200.948,397.980184 202.3865,399.447016 C204.2135,401.373084 206.612,401.312658 207.68,401.513574 C211.52,401.885191 224,402 224,402 C224,402 234.086,401.984894 240.803,401.495446 C241.7405,401.382148 243.7865,401.373084 245.612,399.447016 C247.0505,397.980184 247.52,394.64922 247.52,394.64922 C247.52,394.64922 248,390.73817 248,386.82561 L248,383.157773 C248,379.246723 247.52,375.334163 247.52,375.334163 L247.52,375.334163 Z" id="Youtube"> </path> </g> </g> </g></svg>
                    </a>
                </li>
                <li>
                    <a href="https://t.me/+KxJWbRNlgYc2MGIx"  target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-gray-900">
                        <span class="sr-only">Telegram</span>
                       <svg width="35px" height="35px" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="16" cy="16" r="14" fill="url(#paint0_linear_87_7225)"></circle> <path d="M22.9866 10.2088C23.1112 9.40332 22.3454 8.76755 21.6292 9.082L7.36482 15.3448C6.85123 15.5703 6.8888 16.3483 7.42147 16.5179L10.3631 17.4547C10.9246 17.6335 11.5325 17.541 12.0228 17.2023L18.655 12.6203C18.855 12.4821 19.073 12.7665 18.9021 12.9426L14.1281 17.8646C13.665 18.3421 13.7569 19.1512 14.314 19.5005L19.659 22.8523C20.2585 23.2282 21.0297 22.8506 21.1418 22.1261L22.9866 10.2088Z" fill="white"></path> <defs> <linearGradient id="paint0_linear_87_7225" x1="16" y1="2" x2="16" y2="30" gradientUnits="userSpaceOnUse"> <stop stop-color="#37BBFE"></stop> <stop offset="1" stop-color="#007DBB"></stop> </linearGradient> </defs> </g></svg>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</footer>

@if(!auth()->guest() && auth()->user()->hasAnnouncements())
@include('theme::partials.announcements')
@endif

<!-- Scripts -->
<script src="{{ asset('themes/' . $theme->folder . '/js/app.js') }}"></script>

@yield('javascript')

@if(setting('site.google_analytics_tracking_id', ''))
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('site.google_analytics_tracking_id') }}">
</script>
<script>
    window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{ setting("site.google_analytics_tracking_id") }}');
</script>

@endif