import * as React from "react";
import { AudioWaveform } from "lucide-react";

import {
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from "@/tenant-admin/components/ui/sidebar";
import { usePage } from "@inertiajs/react";
import { Tenant } from "../types/tenant";

export function TeamSwitcher() {
    const { tenant } = usePage<{ tenant: Tenant }>().props;

    return (
        <SidebarMenu>
            <SidebarMenuItem>
                <SidebarMenuButton size="lg" asChild>
                    <a href="#">
                        <div className="flex aspect-square size-8 items-center justify-center rounded-lg bg-sidebar-primary text-sidebar-primary-foreground">
                            <AudioWaveform className="size-4" />
                        </div>
                        <div className="grid flex-1 text-left text-sm leading-tight">
                            <span className="capitalize truncate font-semibold">
                                {tenant.name}
                            </span>
                            <span className="truncate text-xs">
                                Free trail 14 jours
                            </span>
                        </div>
                    </a>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    );
}
