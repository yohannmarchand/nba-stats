export type PlayerStat = {
    rank: number;
    player: {
        first_name: string;
        last_name: string;
        image_url: string | null;
    };
    key: string;
    value: number;
};
