<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';

defineOptions({
    layout: {
        title: 'Inicia sesión en tu cuenta',
        description:
            'Ingresa tu correo electrónico y contraseña para iniciar sesión',
    },
});

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>

<template>
    <Head title="Iniciar sesión" />

    <div
        v-if="status"
        class="mb-4 text-center text-sm font-medium text-green-600"
    >
        {{ status }}
    </div>

    <Form
        v-bind="store.form()"
        :reset-on-success="['password']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-6"
    >
        <div class="grid gap-6">
            <div class="grid gap-2">
                <Label for="email">Correo electrónico</Label>
                <Input
                    id="email"
                    type="email"
                    name="email"
                    required
                    v-focus
                    :tabindex="1"
                    autocomplete="email"
                    placeholder="email@example.com"
                />
                <InputError :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <div class="flex items-center justify-between">
                    <Label for="password">Contraseña</Label>
                    <TextLink
                        v-if="canResetPassword"
                        :href="request()"
                        class="text-sm"
                        :tabindex="5"
                    >
                        ¿Olvidaste tu contraseña?
                    </TextLink>
                </div>
                <PasswordInput
                    id="password"
                    name="password"
                    required
                    :tabindex="2"
                    autocomplete="current-password"
                    placeholder="Contraseña"
                />
                <InputError :message="errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <Label for="remember" class="flex items-center space-x-3">
                    <Checkbox id="remember" name="remember" :tabindex="3" />
                    <span>Recuérdame</span>
                </Label>
            </div>

            <Button
                type="submit"
                class="mt-4 w-full"
                :tabindex="4"
                :disabled="processing"
                data-test="login-button"
            >
                <Spinner v-if="processing" />
                Iniciar sesión
            </Button>
        </div>

        <div class="relative flex items-center justify-center">
            <span class="absolute inset-x-0 border-t"></span>
            <span class="relative bg-background px-3 text-xs text-muted-foreground">
                O continúa con
            </span>
        </div>

        <div class="flex justify-center">
            <Button
                as-child
                variant="outline"
                class="h-10 w-full max-w-[220px] justify-center gap-3 rounded-sm border-[#5f6368] bg-[#2b2b2b] px-4 font-medium text-white hover:bg-[#3c4043] hover:text-white"
            >
                <a href="/auth/google">
                    <span aria-hidden="true" class="text-base font-bold">G</span>
                    Login with Google
                </a>
            </Button>
        </div>

        <div class="text-center text-sm text-muted-foreground">
            ¿No tienes una cuenta?
            <TextLink :href="register()" :tabindex="5">Regístrate</TextLink>
        </div>
    </Form>
</template>
