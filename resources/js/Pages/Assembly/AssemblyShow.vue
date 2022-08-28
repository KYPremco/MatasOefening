<script setup>
import NavLink from "@/Components/NavLink.vue";
import Input from '@/Components/Input.vue';
import Label from '@/Components/Label.vue';
import Button from '@/Components/Button.vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import {useForm} from "@inertiajs/inertia-vue3";

const props = defineProps({
    assembly: Object
});

const form = useForm({
    amount: 1,
});

const submitOrder = () => {
    form.post(route('assemblies.order', props.assembly.data.id));
};
</script>


<template>
    <div class="flex flex-col items-center mt-3 md:mt-6">
        <div class="w-full sm:max-w-4xl mt-6 px-6 py-4 bg-white shadow-md sm:rounded-lg">
            <ValidationErrors class="mb-4"/>
            <div class="flex flex-wrap">
                <div class="columns-4 font-bold text-xl w-1/2">
                    Naam
                </div>
                <div class="w-1/2 text-right">
                    <NavLink :href="route('assemblies.index')"
                             classes="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Ga terug
                    </NavLink>
                </div>
                <div class="">
                    {{ assembly.data.name }}
                </div>
            </div>
            <div class="mt-4">
                <div class="font-bold text-xl">
                    Prijs
                </div>
                <div>
                    {{ assembly.data.price }}
                </div>
            </div>
            <div class="mt-4">
                <div class="font-bold text-xl">
                    Fabrikant
                </div>
                <div>
                    {{ assembly.data.manufacturer.name }}
                </div>
            </div>
            <div class="mt-4">
                <div class="font-bold text-xl">
                    Afbeelding
                </div>
                <div>
                    <img :src="assembly.data.image" alt="Assemblage afbeelding">
                </div>
            </div>
            <form @submit.prevent="submitOrder">
                <div class="mt-4">
                    <div class="font-bold text-xl">
                        Aankoop
                    </div>
                    <div class="">
                        <Label for="orderAmount" value="Aantal"/>
                        <Input id="orderAmount" type="number" class="mt-1 block w-full" v-model="form.amount"
                               required autofocus autocomplete="orderAmount"/>
                    </div>
                    <div class="mt-4">
                        <Button class="bg-blue-600" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                            Koop assembalge
                        </Button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
