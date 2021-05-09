<template>
    <!-- This is an example component -->
    <div class="min-h-screen flex flew-row w-full bg-white">
        <nav class="h-screen flex flex-col w-64 bg-gray-50">
            <div class="p-4">
                <img src="https://tailwindcomponents.com/svg/logo-color.svg" />
            </div>
            <ul class="p-2 space-y-2 flex-1 overflow-auto" style="scrollbar-width: thin;">
                <li>
                    <inertia-link :href="route('admin.dashboard')" v-bind:class="[route().current('admin.dashboard') ? 'bg-gray-200 text-gray-900' : '']" class="flex space-x-2 items-center text-gray-600 p-2 hover:bg-gray-200 rounded-lg hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 fill-current" width="24" height="24" viewBox="0 0 24 24"><path d="M20 7.093v-5.093h-3v2.093l3 3zm4 5.907l-12-12-12 12h3v10h7v-5h4v5h7v-10h3zm-5 8h-3v-5h-8v5h-3v-10.26l7-6.912 7 6.99v10.182z"/></svg>
                        <span class="text-gray-900">Dashboard</span>
                    </inertia-link >
                </li>
                <li>
                    <inertia-link :href="route('admin.user.index')" v-bind:class="[route().current('admin.user.index') && route().params['roles'] != 'Mangaka'  && route().params['roles'] != 'Reader' ? 'bg-gray-200 text-gray-900' : '']" class="flex space-x-2 items-center text-gray-600 p-2 hover:bg-gray-200 rounded-lg hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 fill-current" width="24" height="24" viewBox="0 0 24 24"><path d="M17.997 18h-.998c0-1.552.06-1.775-.88-1.993-1.438-.332-2.797-.645-3.293-1.729-.18-.396-.301-1.048.155-1.907 1.021-1.929 1.277-3.583.702-4.538-.672-1.115-2.707-1.12-3.385.017-.576.968-.316 2.613.713 4.512.465.856.348 1.51.168 1.908-.49 1.089-1.836 1.4-3.262 1.728-.982.227-.92.435-.92 2.002h-.995l-.002-.623c0-1.259.1-1.985 1.588-2.329 1.682-.389 3.344-.736 2.545-2.209-2.366-4.365-.676-6.839 1.865-6.839 2.492 0 4.227 2.383 1.867 6.839-.775 1.464.824 1.812 2.545 2.209 1.49.344 1.589 1.072 1.589 2.333l-.002.619zm4.81-2.214c-1.289-.298-2.489-.559-1.908-1.657 1.77-3.342.47-5.129-1.4-5.129-1.265 0-2.248.817-2.248 2.325 0 1.269.574 2.175.904 2.925h1.048c-.17-.75-1.466-2.562-.766-3.736.412-.692 1.704-.693 2.114-.012.38.631.181 1.812-.534 3.161-.388.733-.28 1.301-.121 1.648.305.666.977.987 1.737 1.208 1.507.441 1.368.042 1.368 1.48h.997l.002-.463c0-.945-.074-1.492-1.193-1.75zm-22.805 2.214h.997c0-1.438-.139-1.039 1.368-1.48.761-.221 1.433-.542 1.737-1.208.159-.348.267-.915-.121-1.648-.715-1.349-.914-2.53-.534-3.161.41-.682 1.702-.681 2.114.012.7 1.175-.596 2.986-.766 3.736h1.048c.33-.75.904-1.656.904-2.925.001-1.509-.982-2.326-2.247-2.326-1.87 0-3.17 1.787-1.4 5.129.581 1.099-.619 1.359-1.908 1.657-1.12.258-1.194.805-1.194 1.751l.002.463z"/></svg>
                        <span>Accounts list</span>
                    </inertia-link>
                </li>
                <li>
                    <inertia-link :href="route('admin.user.index', {_query: {roles: 'Mangaka'}})" v-bind:class="[route().current('admin.user.index') && route().params['roles'] == 'Mangaka' ? 'bg-gray-200 text-gray-900' : '']" class="flex space-x-2 items-center text-gray-600 p-2 hover:bg-gray-200 rounded-lg hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 fill-current" viewBox="0 0 64 64">
                            <path data-name="layer2" fill="none" stroke="#202020" stroke-miterlimit="10" stroke-width="2" d="M9.7 54.3l-7.6 7.6m15.1-10.8a6.5 6.5 0 0 0-4.3-4.3 6 6 0 0 1-5.6.9l-.9.7-.5.7a6.4 6.4 0 0 0-1 1.9c-1.8 4.2-2.8 10.9-2.8 10.9s6.8-.9 11-2.7a6.5 6.5 0 0 0 1.7-1l.7-.6.7-.9a6 6 0 0 1 1-5.6z" stroke-linejoin="round" stroke-linecap="round"></path>
                            <path data-name="layer1" d="M61.1 6.9l-36 40.4a6 6 0 1 1-9-8l.5-.5L57 2.8a2.8 2.8 0 0 1 4 4z" fill="none" stroke="#202020" stroke-miterlimit="10" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                        </svg>
                        <span>Mangakas list</span>
                    </inertia-link>
                </li>
                <li>
                    <inertia-link :href="route('admin.user.index', {_query: {roles: 'Reader'}})" v-bind:class="[route().current('admin.user.index') && route().params['roles'] == 'Reader' ? 'bg-gray-200 text-gray-900' : '']" class="flex space-x-2 items-center text-gray-600 p-2 hover:bg-gray-200 rounded-lg hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 fill-current" viewBox="0 0 64 64">
                            <path data-name="layer2" d="M4.4 33.4L4 34S2.6 52 16 52s12-16 12-16m31.7-2.6l.4.6s1.4 18-12 18-12-16-12-16" fill="none" stroke="#202020" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            <path data-name="layer1" d="M26.1 18c0-4.7-3.1-7.6-6.6-5s-13 17.2-15 20.4M38.1 18c0-4.7 3.1-7.6 6.6-5s13 17.3 15 20.4" fill="none" stroke="#202020" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            <path data-name="layer1" d="M62 34.5S48 26 36 36h-8C16.1 26 2.1 34.5 2.1 34.5" fill="none" stroke="#202020" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <span>Readers list</span>
                    </inertia-link>
                </li>
                <li>
                    <a href="#" class="flex space-x-2 items-center text-gray-600 p-2 hover:bg-gray-200 rounded-lg hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 fill-current" width="24" height="24" viewBox="0 0 24 24"><path d="M10 15v-10h-5.033c-2.743 0-4.967 2.239-4.967 5 0 2.762 2.224 5 4.967 5h5.033zm-8-5c0-1.654 1.331-3 2.967-3h3.033v6h-3.033c-1.636 0-2.967-1.346-2.967-3zm22-10v20c-4.839-3.008-8.836-4.491-12-5v-2.014c3.042.438 6.393 1.624 10 3.548v-13.064c-3.622 1.941-6.912 3.099-10 3.544v-2.014c3.124-.498 7.036-1.915 12-5zm-11.993 22.475c-.52-.424-.902-.994-1.095-1.637l-1.151-3.827h-6.146l1.905 5.883c.214.659.828 1.106 1.522 1.106h4.46c.358 0 .677-.225.797-.562.12-.337.015-.713-.263-.939l-.029-.024zm-4.674-.475l-.982-3h1.933l.927 3h-1.878z"/></svg>
                        <span>Announcements</span>
                    </a>
                </li>
                <li>
                    <inertia-link href="#" @click="logout()" class="flex space-x-2 items-center text-gray-600 p-2 hover:bg-gray-200 rounded-lg hover:text-gray-900 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 fill-current" viewBox="0 0 64 64">
                            <path data-name="layer2" fill="none" stroke="#202020" stroke-miterlimit="10" stroke-width="2" d="M28 24l-9 8 9 8m26-8H19" stroke-linejoin="round" stroke-linecap="round"></path>
                            <path data-name="layer1" fill="none" stroke="#202020" stroke-miterlimit="10" stroke-width="2" d="M10 12v40" stroke-linejoin="round" stroke-linecap="round"></path>
                        </svg>
                        <span>Log Out</span>
                    </inertia-link>
                </li>

            </ul>

            <div class="p-2 flex items-center border-t-2 border-gray-300 space-x-4">
                <div class="relative inline-flex">
                    <img class='w-8 h-8 object-cover rounded-full' alt='User avatar' src='https://images.unsplash.com/photo-1477118476589-bff2c5c4cfbb?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=200&q=200' />
                </div>
                <div>
                    <h3 class="font-semibold tracking-wide text-gray-800">
                        {{this.$page.props.user.first_name}} {{this.$page.props.user.last_name}}
                    </h3>
                    <inertia-link class="text-sm text-gray-700" :href="route('profile.show')">
                        view profile
                    </inertia-link>
                </div>
            </div>
        </nav>
        <div class="w-full">
            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>
        </div>
    </div>

</template>

<script>
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'

    export default {
        components: {
            JetResponsiveNavLink,
        },
        methods: {
            logout() {
                this.$inertia.post(route('logout'));
            },
        },
    }
</script>
