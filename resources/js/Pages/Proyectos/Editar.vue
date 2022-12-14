<script setup>
import { onBeforeMount } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import TextAreaInput from "@/Components/TextAreaInput.vue";

const props = defineProps({
    proyecto: Object,
});

const form = useForm({
    id: -1,
    nombre: "",
    responsable: "",
});

onBeforeMount(() => {
    const { id, nombre, responsable } = props.proyecto;
    form.id = id;
    form.nombre = nombre;
    form.responsable = responsable;
});

const submit = () => {
    form.post(route("editar-proyecto-post", form));
};
</script>
<template>
    <Head title="Nuevo proyecto" />
    <AuthenticatedLayout>
        <div
            class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 mt-10"
        >
            <h1 class="text-2xl text-gray-600">Editar proyecto</h1>
            <div
                class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
            >
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="nombre" value="Nombre del proyecto" />
                        <TextAreaInput
                            rows="5"
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.nombre"
                            required
                            autofocus
                            autocomplete="nombre"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.nombre"
                        />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="responsable" value="Responsable" />
                        <TextInput
                            id="responsable"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.responsable"
                            required
                            autocomplete="responsable"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.responsable"
                        />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton
                            class="ml-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Editar
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
