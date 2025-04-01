export function createSkeleton(type) {
    const skeletons = {
        post: `
            <div class="animate-pulse">
                <div class="aspect-square bg-[#161830] rounded-xl mb-4"></div>
                <div class="h-4 bg-[#161830] rounded w-3/4 mb-2"></div>
                <div class="h-4 bg-[#161830] rounded w-1/2"></div>
            </div>
        `,
        profile: `
            <div class="animate-pulse flex items-center gap-3">
                <div class="w-12 h-12 bg-[#161830] rounded-full"></div>
                <div>
                    <div class="h-4 bg-[#161830] rounded w-24 mb-2"></div>
                    <div class="h-3 bg-[#161830] rounded w-16"></div>
                </div>
            </div>
        `
    };
    return skeletons[type];
}