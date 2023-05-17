<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import {router, useForm, usePage} from '@inertiajs/vue3';
    
    import InputLabel from "@/Components/InputLabel.vue";
    import InputError from '@/Components/InputError.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from "@/Components/TextInput.vue";

    const props = defineProps({
        product:{
            type:Object,
            required:false
        }
    });

    const form = useForm({
        id: props.product?.id ?? '',
        name: props.product?.name ?? '',
        quantity: props.product?.quantity ?? '',
        price: props.product?.price ?? ''
    });

    const store = () => {
        form.post(route('products.store'), {
            replace: true,
        });
    };

    const update = () => {
        form.patch(route('products.update', { id: props.product.id }), {
            replace: true,
        });
    };


</script>

<template>
    <AppLayout title="Product">
       
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <section class="flex flex-col p-6 ">
                        <header>
                            <h2 class="text-lg font-medium text-white">{{props.product == null ? 'Create a New Product' : 'Edit a Product'}}</h2>
                        </header>

                        <form @submit.prevent = "(props.product == null ? store() : update())" class="mt-6 space-y-6 block S">
                            <div class="grid grid-cols-1 ">
                                <div>
                                    <div>
                                        <InputLabel for="name" value="Name" />
                                        <TextInput
                                            id="name"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.name"
                                            required
                                        />
                                        <InputError class="mt-2" :message="form.errors.name" />
                                    </div>
                                    <div>
                                        <InputLabel for="quantity" value="Quantity" />
                                        <TextInput
                                            id="quantity"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.quantity"
                                            required
                                        />
                                        <InputError class="mt-2" :message="form.errors.quantity" />
                                    </div>
                                    <div>
                                        <InputLabel for="price" value="Price" />
                                        <TextInput
                                            id="price"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.price"
                                            required
                                        />
                                        <InputError class="mt-2" :message="form.errors.price" />
                                    </div>    
                                </div>
                            </div>                                
                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Submit</PrimaryButton>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AppLayout>

</template>