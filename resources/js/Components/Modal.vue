<script setup lang="ts">
import BackDrop from "@/Components/BackDrop.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

withDefaults(
    defineProps<{
        modelValue: boolean;
        size?: string;
        title: string;
        hiddenFooter?: boolean;
        centerModal?: boolean;
    }>(),
    {
        size: "sm",
        hiddenFooter: false,
        centerModal: false,
    }
);

const emits = defineEmits<{
    (e: "update:modelValue", value: boolean): void;
}>();


</script>
<template>
    <Teleport to="body">
        <div class="modal" v-if="modelValue">
            <BackDrop />
            <div
                class="fixed inset-0 z-[70] overflow-y-auto overflow-x-hidden transition-all duration-300 ease-in-out"
            >
                <div
                    class="flex justify-center px-4 pb-10"
                    :class="{
                        'items-center min-h-screen pt-4': !centerModal,
                        'pt-10': centerModal,
                    }"
                >
                    <!-- modal -->
                    <div
                        class="relative bg-white rounded-md w-full dark:bg-gray-700 dark:border dark:border-gray-400"
                        :class="{
                            'md:w-2/6': size == 'sm',
                            'md:w-2/4': size == 'md',
                            'md:w-3/4': size == 'lg',
                            'md:w-full': size == 'xl',
                        }"
                    >
                        <!-- modal header -->
                        <div
                            class="modal-header h-14 flex items-center justify-between px-4 rounded-t-md border dark:border-gray-400"
                        >
                            <h1
                                class="text-black font-bold text-xl dark:text-white"
                            >
                                {{ title }}
                            </h1>
                            <PrimaryButton
                                @click="emits('update:modelValue', false)"
                                >x</PrimaryButton
                            >
                        </div>
                        <!-- modal content -->
                        <div class="modal-content p-4">
                            <slot name="content"></slot>
                        </div>
                        <!-- modal footer -->
                        <div
                            class="modal-footer h-14 border flex items-center px-4"
                            v-if="!hiddenFooter"
                        >
                            <slot name="footer"></slot>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>
