<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import {
    LayoutDashboard,
    MessageCircle,
    Palette,
    Ruler,
    Shirt,
    Sun,
    Tags,
    Users,
} from '@lucide/vue';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { edit as editAppearance } from '@/routes/appearance';
import type { NavItem } from '@/types';

const page = usePage();

const mainNavItems = computed<NavItem[]>(() => [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutDashboard,
    },
    ...(page.props.auth.user?.rol === 2
        ? [
              {
                  title: 'Tallas',
                  href: '/tallas',
                  icon: Ruler,
              },
              {
                  title: 'Colores',
                  href: '/colores',
                  icon: Palette,
              },
              {
                  title: 'Usuarios',
                  href: '/usuarios',
                  icon: Users,
              },
              {
                  title: 'Categorías',
                  href: '/categorias',
                  icon: Tags,
              },
              {
                  title: 'Productos',
                  href: '/productos/admin',
                  icon: Shirt,
              },
          ]
        : []),
]);

const footerNavItems: NavItem[] = [
    {
        title: 'Whatsapp',
        href: 'https://wa.link/your-whatsapp-link',
        icon: MessageCircle,
    },
    {
        title: 'Tema',
        href: editAppearance(),
        icon: Sun,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
