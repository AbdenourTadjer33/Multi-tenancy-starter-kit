import { UUID } from "crypto";

type Tenant = {
    id: UUID;
    name: string;
    plan: string;
};

export { Tenant };
