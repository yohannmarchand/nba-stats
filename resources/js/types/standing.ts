export type StandingEntry = {
    rank: number;
    team: {
        name: string;
        logo: string | null;
    };
    wins: number;
    losses: number;
    pct: number;
};
