<template>
    <mangaka-layout>
        <div class="h-screen w-full flex overflow-hidden">
            <main class="flex-1 flex flex-col bg-gray-100 dark:bg-gray-700 transition duration-500 ease-in-out overflow-y-auto">
                <div class="mx-10 my-2">
                    <h2 class="my-4 text-4xl font-semibold dark:text-gray-400">
                        <span>Mangas List</span>
                    </h2>
                    <div class="pb-2 flex items-center justify-between text-gray-600 dark:text-gray-400 border-b dark:border-gray-600">
                        <!-- Header -->
                        <div>
                            <span class="pr-5">
                                <span class="text-red-500 dark:text-red-200">
                                    {{this.mangas.length}}
                                </span>
                                Total Mangas
                            </span>
                            <span class="pr-5">
                                <span class="text-red-500 dark:text-red-200">
                                    {{this.mangas.filter(manga => manga.isMature == true).length}}
                                </span>
                                Mature Mangas
                            </span>
                        </div>
                        <div>
                            <input type="search" v-model="search" placeholder="Search a manga.." class="inline-flex items-center px-3 py-2 my-2 mx-1 rounded-md font-semibold text-xs"/>
                            <button id="add" @click="Add" class="inline-flex items-center px-3 py-2 my-2 mx-1 ml-10 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">Create a Manga</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-3">
                        <manga-card class="my-3" v-for="manga in this.MangaList" v-bind:key="manga.id" v-bind:manga="manga"/>
                    </div>
                    <p v-if="this.MangaList.length == 0" class="w-auto m-auto text-center">No manga to display</p>
                </div>
	        </main>
        </div>
    </mangaka-layout>
</template>

<script>
    import MangakaLayout from '@/Layouts/MangakaLayout'
    import MangaCard from '@/Components/Mangaka/MangaCard'

    export default {
        components: {
            MangakaLayout,MangaCard
        },

        props: ['mangas'],

        data() {
            return {
                search:''
            };
        },

        methods: {
            Add(){
                this.$inertia.visit(route('mangaka.mangas.create'))
            },
        },

        computed:{
            MangaList() {
                var results = [];
                for(var i=0; i<this.mangas.length; i++) {
                    var matching = false;
                    for(var key in this.mangas[i]) {
                        if(key=="name"||key=="slug"){
                            if(this.mangas[i][key].indexOf(this.search.toLowerCase())!=-1) {
                                matching = true;
                            }
                        }
                    }
                    if(matching == true){
                        results.push(this.mangas[i]);
                    }
                }
                return results;
            },
        },
    }
</script>

