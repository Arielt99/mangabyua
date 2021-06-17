<template>
    <admin-layout>
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
                            <input type="search" v-model="search" placeholder="Search a tag.." class="inline-flex items-center px-3 py-2 my-2 mx-1 rounded-md font-semibold text-xs"/>
                            <button id="add" @click="Add" class="inline-flex items-center px-3 py-2 my-2 mx-1 ml-10 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">Create a Manga</button>
                        </div>
                    </div>
                    <div class="mt-2 flex px-4 justify-between text-gray-600 dark:text-gray-400 capitalize">
                        <!-- List sorting -->
                        <div @click="this.sort == 'asc.id' ? Sort('desc.id') : Sort('asc.id')" class="w-20 flex items-center">
                            <span>id</span>
                            <svg v-if="this.sort == 'asc.id'" class="ml-1 h-5 w-5 fill-current text-red-500 dark:text-red-200" viewBox="0 0 24 24">
                                <path d="M18 21l-4-4h3V7l2 0v10h3M 2 19v-2h10v2M2 13v-2h7v2M2 7V5h4v2H2z"></path>
                            </svg>
                            <svg v-else-if="this.sort == 'desc.id'" class="ml-1 h-5 w-5 fill-current text-red-500 dark:text-red-200" viewBox="0 0 24 24">
                                <path d="M17 17V7h-3l4-4l4 4h-3v10h3M2 19v-2h10v2M2 13v-2h7v2M2 7V5h4v2H2z"></path>

                            </svg>
                            <svg v-else class="ml-1 h-5 w-5 fill-current" viewBox="0 0 24 24">
                                <path d="M18 21l-4-4h3V7h-3l4-4 4 4h-3v10h3M2 19v-2h10v2M2 13v-2h7v2M2 7V5h4v2H2z"></path>
                            </svg>
                        </div>
                    </div>
                    <manga-card v-for="manga in this.MangaList" v-bind:key="manga.id" v-bind:manga="manga"/>
                    <p v-if="this.MangaList.length == 0" class="w-auto m-auto text-center">No manga to display</p>
                </div>
	        </main>
        </div>
    </admin-layout>
</template>

<script>
import AdminLayout from '@/Layouts/MangakaLayout'
import MangaCard from '@/Components/Mangaka/MangaCard'

export default {
    components: {
        AdminLayout,MangaCard
    },

    props: ['mangas'],

    data() {
        return {
            sort:null,
            search:''
        };
    },

    methods: {
        Add(){
            //this.$inertia.visit(route('admin.mangas.create'))
        },
        Sort(parameter){
            switch (parameter) {
                case 'asc.id':
                        this.MangaList.sort(function(a, b) {
                            return a.id - b.id;
                        });
                        this.sort = parameter
                    break;
                case 'desc.id':
                        this.MangaList.sort(function(a, b) {
                            return a.id - b.id;
                        }).reverse();
                        this.sort = parameter
                    break;
                default:
                    this.sort = null
                    console.log(`Sorry, we are out of ${parameter}.`);
            }
        }
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

    beforeMount(){
        //console.log(route().params['manga']);
    },
}
</script>

