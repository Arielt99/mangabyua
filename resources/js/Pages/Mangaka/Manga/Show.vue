<template>
    <mangaka-layout>
        <div class="h-screen w-full flex overflow-hidden">
            <main class="flex-1 flex flex-col bg-gray-100 dark:bg-gray-700 transition duration-500 ease-in-out overflow-y-auto">
                <div class="mx-10 my-2">
                    <h2 class="my-4 flex flex-row text-4xl font-semibold dark:text-gray-400">
                        <a href="#" class="pr-3 flex content-center" @click="Back">
                            <svg viewBox="0 0 64 64" class="w-7 fill-current" xmlns="http://www.w3.org/2000/svg" role="img" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <path stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke="#202020" fill="none" d="M3 46h44a15 15 0 0 0 15-15 15 15 0 0 0-15-15H2" data-name="layer2" stroke-linejoin="round"></path>
                                <path d="M16 34L3 46l13 12" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke="#202020" fill="none" data-name="layer1" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                        <span>{{this.mangas.title}}’s informations</span>
                    </h2>
                    <div class="pb-2 flex items-center justify-between text-gray-600 dark:text-gray-400 border-b dark:border-gray-600">
                        <div class="flex ">
                            <span class="pr-5">
                                created
                                <span class="text-red-500 dark:text-red-200">
                                    {{configDateTime(this.mangas.created_at)}}
                                </span>
                            </span>
                            <span class="pr-5">
                                last update
                                <span class="text-red-500 dark:text-red-200">
                                    {{configDateTime(this.mangas.updated_at)}}
                                </span>
                            </span>
                        </div>
                        <div class="flex">
                            <span @click="Edit()" class="w-7 bg-yellow-500 text-gray-200 rounded hover:bg-yellow-400 px-1 py-1 focus:outline-none mx-1 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-white" viewBox="0 0 64 64">
                                    <path data-name="layer1" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" d="M56 2.4l-26.1 26-4 9.7 9.7-4.1 26-26L56 2.4z" stroke-linejoin="round" stroke-linecap="round"></path>
                                    <path data-name="layer2" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" d="M34.4 11.6h-32v50h50v-32" stroke-linejoin="round" stroke-linecap="round"></path>
                                    <path data-name="layer1" fill="none" stroke="#202020" stroke-miterlimit="10" stroke-width="2" d="M50.8 7.6l5.6 5.6" stroke-linejoin="round" stroke-linecap="round"></path>
                                </svg>
                            </span>
                            <span @click="Delete()" class="w-7 bg-red-500 text-gray-200 rounded hover:bg-red-400 px-1 py-1 focus:outline-none mx-1 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-white" viewBox="0 0 64 64">
                                    <path data-name="layer2" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" d="M6 10h52m-36 0V5.9A3.9 3.9 0 0 1 25.9 2h12.2A3.9 3.9 0 0 1 42 5.9V10m10.5 0l-2.9 47.1a5 5 0 0 1-4.9 4.9H19.3a5 5 0 0 1-4.9-4.9L11.5 10" stroke-linejoin="round" stroke-linecap="round"></path>
                                    <path data-name="layer1" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" d="M32 18v36M22 18l2 36m18-36l-2 36" stroke-linejoin="round" stroke-linecap="round"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-3 sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Title</label>
                                        <p>{{this.mangas.title}}</p>
                                    </div>

                                    <div class="col-span-3 sm:col-span-3">
                                        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                                        <p>{{this.mangas.slug}}</p>
                                    </div>
                                    <div class="col-span-4 sm:col-span-4">
                                        <label for="mangakas" class="block text-sm font-medium text-gray-700">Authors</label>
                                        <div class="flex flex-row">
                                            <div v-for="(mangaka, index) in this.mangas.mangakas" v-bind:key="mangaka.id" class="mt-2">
                                                <span v-if="index < this.mangas.mangakas.length && index != 0">, </span>
                                                <span class="mb-1 text-black dark:text-gray-200">
                                                    {{mangaka.full_name}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-4 sm:col-span-4">
                                        <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                                        <div class="flex flex-row">
                                            <div v-for="(tag, index) in this.mangas.tags" v-bind:key="tag.id" class="mt-2">
                                                <span v-if="index < this.mangas.tags.length && index != 0">, </span>
                                                <span class="mb-1 text-black dark:text-gray-200">
                                                    {{tag.name}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-2 sm:col-span-2">
                                    </div>
                                    <div class="col-span-1 sm:col-span-1">
                                        <label for="isMature" class="flex flex-row content-center text-sm font-medium text-gray-700 inline row">
                                            <input type="checkbox" disabled v-model="this.mangas.isMature" true-value=1 false-value=0 name="isMature" id="isMature" class=" mr-2 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <p>Mature content</p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </mangaka-layout>
    <jet-dialog-modal :show="this.ConfirmDeletion" @close="this.ConfirmDeletion = false">
        <template #title>
            Delete User
        </template>

        <template #content>
            Are you sure you want to delete user {{this.user.username}}? Once it is deleted, all of its resources and data will be permanently deleted.
        </template>

        <template #footer>
            <jet-secondary-button @click="ConfirmDeletion = false">
                Nevermind
            </jet-secondary-button>

            <jet-danger-button class="ml-2" @click="deleteUser" :class="{ 'opacity-25': delTag.processing }" :disabled="delTag.processing">
                Delete User
            </jet-danger-button>
        </template>
    </jet-dialog-modal>
</template>
<script>
    import MangakaLayout from '@/Layouts/MangakaLayout'
    import JetDialogModal from './../../../Jetstream/DialogModal'
    import JetDangerButton from './../../../Jetstream/DangerButton'
    import JetSecondaryButton from './../../../Jetstream/SecondaryButton'
    import moment from 'moment'

    export default {
        components: {
            MangakaLayout,
            JetDialogModal,
            JetSecondaryButton,
            JetDangerButton
        },

        props: ['mangas'],

        data () {
            return {
                ConfirmDeletion:false,

                delTag: this.$inertia.form({
                    '_method': 'DELETE',
                },{
                    bag: 'deleteTag'
                })
            }
        },

        methods:{
            Back() {
                window.history.back();
            },
            //date configuration with moment.js
            configDateTime(date) {
                return moment(date).locale("en").format("MMM Do YYYY");
            },
            Edit(){
                this.$inertia.visit(route('admin.mangas.edit', {id: this.mangas.id}))
            },
            Delete(){
                this.ConfirmDeletion = true
            },
            deleteUser(){
                this.delTag.post(route('admin.mangas.destroy', {id: this.mangas.id}), {
                    preserveScroll: true
                })
            },
        },
        beforeMount(){
        console.log(this.mangas);
        },
    }
</script>
