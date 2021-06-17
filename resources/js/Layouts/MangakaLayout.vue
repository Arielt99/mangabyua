<template>
    <!-- This is an example component -->
    <div class="min-h-screen flex flew-row w-full bg-white">
        <nav class="h-screen flex flex-col w-64 bg-gray-50">
            <div class="p-4">
                <h2 class="text-2xl	font-black uppercase text-center">Mangabyua</h2>
            </div>
            <ul class="p-2 space-y-2 flex-1 overflow-auto" style="scrollbar-width: thin;">
                <li>
                    <inertia-link :href="route('mangaka.dashboard')" v-bind:class="[route().current('mangaka.dashboard') ? 'bg-gray-200 text-gray-900' : '']" class="flex space-x-2 items-center text-gray-600 p-2 hover:bg-gray-200 rounded-lg hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 fill-current" width="24" height="24" viewBox="0 0 24 24"><path d="M20 7.093v-5.093h-3v2.093l3 3zm4 5.907l-12-12-12 12h3v10h7v-5h4v5h7v-10h3zm-5 8h-3v-5h-8v5h-3v-10.26l7-6.912 7 6.99v10.182z"/></svg>
                        <span class="text-gray-900">Dashboard</span>
                    </inertia-link >
                </li>
                <li>
                    <inertia-link :href="route('mangaka.mangas.index')" v-bind:class="[route().current('mangaka.mangas.index') ? 'bg-gray-200 text-gray-900' : '']" class="flex space-x-2 items-center text-gray-600 p-2 hover:bg-gray-200 rounded-lg hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 fill-current" viewBox="0 0 64 64">
                            <path data-name="layer2" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="4" d="M9.7 54.3l-7.6 7.6m15.1-10.8a6.5 6.5 0 0 0-4.3-4.3 6 6 0 0 1-5.6.9l-.9.7-.5.7a6.4 6.4 0 0 0-1 1.9c-1.8 4.2-2.8 10.9-2.8 10.9s6.8-.9 11-2.7a6.5 6.5 0 0 0 1.7-1l.7-.6.7-.9a6 6 0 0 1 1-5.6z" stroke-linejoin="round" stroke-linecap="round"></path>
                            <path data-name="layer1" d="M61.1 6.9l-36 40.4a6 6 0 1 1-9-8l.5-.5L57 2.8a2.8 2.8 0 0 1 4 4z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="4" stroke-linejoin="round" stroke-linecap="round"></path>
                        </svg>
                        <span>Mangas list</span>
                    </inertia-link>
                </li>
                <li>
                    <inertia-link href="#" @click="logout()" class="flex space-x-2 items-center text-gray-600 p-2 hover:bg-gray-200 rounded-lg hover:text-gray-900 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 fill-current" viewBox="0 0 64 64">
                            <path data-name="layer2" fill="none" stroke="currentColor" stroke-width="4" stroke-miterlimit="10" d="M28 24l-9 8 9 8m26-8H19" stroke-linejoin="round" stroke-linecap="round"></path>
                            <path data-name="layer1" fill="none" stroke="currentColor" stroke-width="4"  stroke-miterlimit="10" d="M10 12v40" stroke-linejoin="round" stroke-linecap="round"></path>
                        </svg>
                        <span>Log Out</span>
                    </inertia-link>
                </li>

            </ul>

            <div class="p-2 flex items-center border-t-2 border-gray-300 space-x-4">
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
