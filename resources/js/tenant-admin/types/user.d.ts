import { UUID } from "crypto";

type User = {
    id: UUID;
    name: string;
    email: string;
    avatar?: string;
};

export { User };
