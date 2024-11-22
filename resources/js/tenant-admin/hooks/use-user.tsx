import React from "react";
import { User } from "@/tenant-admin/types/user";
import { usePage } from "@inertiajs/react";

const UserContext = React.createContext<User | null>(null);

const UserProvider: React.FC<{ children: React.ReactNode }> = ({
    children,
}) => {
    const { user } = usePage<{ user: User }>().props;
    return <UserContext.Provider value={user}>{children}</UserContext.Provider>;
};

const useUser = (...attributes: (keyof User)[]): User => {
    const context = React.useContext(UserContext);

    if (!context) {
        throw new Error("useUser must be used within a UserProvider");
    }

    if (attributes.length) {
        return attributes.reduce((selectedAttributes: any, attribute) => {
            selectedAttributes[attribute] = context[attribute];
            return selectedAttributes;
        }, {});
    }

    return context;
};

export { UserProvider, useUser };
