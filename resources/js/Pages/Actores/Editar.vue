<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import TextAreaInput from "@/Components/TextAreaInput.vue";

const props = defineProps({
    actor: Object,
});

const form = useForm(props.actor);

const submit = () => {
    form.post(route("editar-actor"));
};
</script>

<template>
    <Head title="Nuevo actor" />
    <AuthenticatedLayout>
        <div
            class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 mt-10"
        >
            <h1 class="text-2xl text-gray-600">Editar actor</h1>
            <div
                class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
            >
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="id" value="Id" />
                        <TextInput
                            id="id"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.id"
                            required
                            autocomplete="id"
                            disabled
                        />
                        <InputError class="mt-2" :message="form.errors.id" />
                    </div>
                    <div>
                        <InputLabel for="clave" value="Clave" />
                        <TextInput
                            id="clave"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.clave"
                            required
                            autocomplete="clave"
                        />
                        <InputError class="mt-2" :message="form.errors.clave" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="nombre" value="Nombre" />
                        <TextInput
                            id="nombre"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.nombre"
                            required
                            autocomplete="nombre"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.nombre"
                        />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="descripcion" value="Descripcion" />
                        <TextAreaInput
                            rows="3"
                            id="descripcion"
                            class="mt-1 block w-full"
                            v-model="form.descripcion"
                            required
                            autofocus
                            autocomplete="descripcion"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.descripcion"
                        />
                    </div>

                    <div class="mt-4">
                        <InputLabel
                            for="caracteristicas"
                            value="Caracteristicas"
                        />
                        <TextAreaInput
                            rows="3"
                            id="caracteristicas"
                            class="mt-1 block w-full"
                            v-model="form.caracteristicas"
                            required
                            autofocus
                            autocomplete="caracteristicas"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.caracteristicas"
                        />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="relaciones" value="Relaciones" />
                        <TextAreaInput
                            rows="3"
                            id="relaciones"
                            class="mt-1 block w-full"
                            v-model="form.relaciones"
                            required
                            autofocus
                            autocomplete="relaciones"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.relaciones"
                        />
                    </div>

                    <div class="mt-4">
                        <InputLabel
                            for="responsabilidad"
                            value="Responsabilidad"
                        />
                        <TextAreaInput
                            rows="3"
                            id="responsabilidad"
                            class="mt-1 block w-full"
                            v-model="form.responsabilidad"
                            required
                            autofocus
                            autocomplete="responsabilidad"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.responsabilidad"
                        />
                    </div>

                    <div class="mt-4">
                        <InputLabel
                            for="actividades_entrada"
                            value="Actividades de entrada"
                        />
                        <TextAreaInput
                            rows="3"
                            id="actividades_entrada"
                            class="mt-1 block w-full"
                            v-model="form.actividades_entrada"
                            required
                            autofocus
                            autocomplete="actividades_entrada"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.actividades_entrada"
                        />
                    </div>

                    <div class="mt-4">
                        <InputLabel
                            for="actividades_salida"
                            value="Actividades de salida"
                        />
                        <TextAreaInput
                            rows="3"
                            id="actividades_salida"
                            class="mt-1 block w-full"
                            v-model="form.actividades_salida"
                            required
                            autofocus
                            autocomplete="actividades_salida"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.actividades_salida"
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
