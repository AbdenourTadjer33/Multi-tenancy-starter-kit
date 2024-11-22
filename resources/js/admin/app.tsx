import "./bootstrap";

import { createInertiaApp } from "@inertiajs/react";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createRoot } from "react-dom/client";
import { Ziggy } from "../ziggy";

globalThis.Ziggy = Ziggy;
globalThis.route = route;

const appName = import.meta.env.VITE_APP_NAME || "laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        return resolvePageComponent(
            `./pages/${name}.tsx`,
            import.meta.glob("./pages/**/*.tsx")
        );
    },
    setup: ({ el, App, props }) => {
        createRoot(el).render(<App {...props} />);
    },
    progress: {
        color: "#4B5563",
    },
}).then(() => document.getElementById("app")?.removeAttribute("data-page"));
