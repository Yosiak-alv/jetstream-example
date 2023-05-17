<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { Link, usePage,router } from '@inertiajs/vue3';
    import {ref, watch} from "vue";

    import {debounce} from 'lodash';
    
    import PrimaryButton from '@/Components/PrimaryButton.vue'
    import TextInput from "@/Components/TextInput.vue";
    import InputLabel from "@/Components/InputLabel.vue";
    import Paginate from '@/Components/Paginate.vue';
    const props = defineProps({
        products:{
            type:Object,
            required:true
        },
        filters:{
            type:Object
        }
    });
    
    const permissions = usePage().props.auth.user_permissions;

    const search = ref(props.filters.search)
    watch(search , debounce(value => {
        router.get('/products',{search:value},{preserveState: true ,replace: true})
    },500));
</script>

<template>
    <AppLayout title="Products">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Products
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    
                    <div class="flex justify-between mt-6">
                        <div class="px-6 ">
                            <InputLabel for="search" value="Search" class="spacing-x-3" />
                            <TextInput id="search" type="text" v-model="search"  class="mt-1"/>
                        </div>
                        <div class="px-6 mt-6">
                            <PrimaryButton><Link :href="route('products.create')" method="get" as="button" >Create new Product.</Link></PrimaryButton>
                        </div>
                    </div>

                    <div class="flex flex-col p-6 ">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Product name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Quantity
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Price
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="product in props.products.data" :key="product.id" 
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ product.name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{product.quantity}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{product.price}}
                                        </td>
                                        <td class="px-6 py-4 space-x-4">
                                            <Link :href="route('products.edit',product.id)" as="button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline ">Edit</Link>                           
                                            <Link v-if="permissions.some( permission => permission['name'] == 'delete product' )"
                                            :href="route('products.destroy',product.id)" as="button" method="delete" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</Link>                           
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>    
                    <Paginate :links="props.products.links"/>
                   
                </div>
            </div>
        </div>
    </AppLayout>

</template>