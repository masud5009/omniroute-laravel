        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="p-4 rounded-xl bg-[#09090b] border border-white/5 space-y-3">
                <div class="flex items-center justify-between gap-3">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-400">Logo</label>
                    @if($siteSettings->logoUrl())
                        <img src="{{ $siteSettings->logoUrl() }}" alt="Current logo" class="w-10 h-10 rounded-lg object-cover border border-white/10">
                    @else
                        <span class="text-xs text-zinc-500 font-mono">Default icon</span>
                    @endif
                </div>
                <input type="file" name="logo" accept="image/*" class="w-full text-xs text-zinc-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-500 file:text-zinc-950 file:font-bold file:text-xs file:cursor-pointer hover:file:bg-emerald-400 bg-[#121215] border border-white/10 rounded-xl p-2">
                <p class="text-xs text-zinc-500">PNG/JPG/SVG/WEBP, max 2MB.</p>
                @if($siteSettings->logo_path)
                    <label class="flex items-center gap-2 text-xs text-zinc-400 cursor-pointer">
                        <input type="checkbox" name="remove_logo" value="1" class="rounded border-zinc-700 text-rose-500 focus:ring-rose-500">
                        <span>Remove current logo</span>
                    </label>
                @endif
            </div>
            <div class="p-4 rounded-xl bg-[#09090b] border border-white/5 space-y-3">
                <div class="flex items-center justify-between gap-3">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-400">Favicon</label>
                    @if($siteSettings->faviconUrl())
                        <img src="{{ $siteSettings->faviconUrl() }}" alt="Current favicon" class="w-8 h-8 rounded-md object-cover border border-white/10 bg-white">
                    @else
                        <span class="text-xs text-zinc-500 font-mono">Default favicon.ico</span>
                    @endif
                </div>
                <input type="file" name="favicon" accept=".ico,.png,.jpg,.jpeg,.svg,.webp" class="w-full text-xs text-zinc-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-500 file:text-zinc-950 file:font-bold file:text-xs file:cursor-pointer hover:file:bg-emerald-400 bg-[#121215] border border-white/10 rounded-xl p-2">
                <p class="text-xs text-zinc-500">ICO/PNG/SVG, max 1MB.</p>
                @if($siteSettings->favicon_path)
                    <label class="flex items-center gap-2 text-xs text-zinc-400 cursor-pointer">
                        <input type="checkbox" name="remove_favicon" value="1" class="rounded border-zinc-700 text-rose-500 focus:ring-rose-500">
                        <span>Remove current favicon</span>
                    </label>
                @endif
            </div>
        </div>
        <div class="pt-3 border-t border-white/[0.06] flex items-center justify-end">
            <button type="submit" class="px-5 py-2.5 bg-white text-zinc-950 hover:bg-zinc-200 font-bold text-xs rounded-xl transition-all shadow-md flex items-center gap-2 cursor-pointer">
                <i data-lucide="save" class="w-3.5 h-3.5"></i>
                <span>Save Website Settings</span>
            </button>
        </div>
    </form>
</div>
