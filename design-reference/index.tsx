import { createFileRoute } from "@tanstack/react-router";
import { useEffect, useState, type FormEvent, type ReactNode } from "react";
import { z } from "zod";
import { toast } from "sonner";
import { Toaster } from "@/components/ui/sonner";
import {
  Phone,
  MessageCircle,
  ShieldCheck,
  Check,
  ArrowLeft,
  Star,
  Clock,
  Users,
  Award,
  Mail,
  MapPin,
  PenLine,
  Search,
  Lightbulb,
  HeartHandshake,
  Home,
  Building2,
  Wallet,
  TrendingDown,
  Briefcase,
  Landmark,
  type LucideIcon,
} from "lucide-react";
import rejectionImg from "@/assets/black-rejection.jpg";
import familyImg from "@/assets/black-family-home.jpg";
import handshakeImg from "@/assets/black-handshake.jpg";
import logoAsset from "@/assets/metadoc-logo.png.asset.json";

const PHONE_TEL = "0506001032";
const PHONE_DISPLAY = "050-600-1032";
const EMAIL = "office@metadoc.co.il";
const ADDRESS = "הדובדבן 9, קריית אונו";
const WHATSAPP =
  "https://wa.me/972506001032?text=" +
  encodeURIComponent("שלום, אשמח לבדיקת זכאות למשכנתא");

const ORANGE = "#ff7a00";
const ORANGE_SOFT = "#ff9a3c";
const ORANGE_MUTED = "#d96a10"; // darker, less glowing
const INK = "#0a0a0a";

// Unified heading & body font stacks
const fontDisplay = { fontFamily: "var(--md-display, 'Barlev', 'Atlas', system-ui, sans-serif)" } as const;
const fontBody = { fontFamily: "'Atlas', 'Assistant', system-ui, sans-serif" } as const;

type DisplayVariant = "barlev" | "anomalia";
const DISPLAY_STACKS: Record<DisplayVariant, string> = {
  barlev: "'Barlev', 'Atlas', system-ui, sans-serif",
  anomalia: "'Anomalia', 'Barlev', 'Atlas', system-ui, sans-serif",
};

export const Route = createFileRoute("/")({
  head: () => ({
    meta: [
      { title: "מטאדוק | סורבתם למשכנתא? יש פתרון" },
      {
        name: "description",
        content:
          "מטאדוק מתמחה בליווי לקוחות שנדחו על ידי הבנקים. למעלה מ-15 שנות ניסיון בבניית פתרונות מימון יצירתיים. השאירו פרטים לבדיקה ללא התחייבות.",
      },
      { property: "og:title", content: "סורבתם למשכנתא? מטאדוק כאן בשבילכם" },
      {
        property: "og:description",
        content: "איפה שאחרים רואים סירוב – אנחנו רואים אפשרויות.",
      },
      { property: "og:image", content: familyImg },
    ],
    links: [{ rel: "canonical", href: "/" }],
  }),
  component: Landing,
});

const leadSchema = z.object({
  name: z.string().trim().min(2, "נא להזין שם מלא").max(60),
  phone: z
    .string()
    .trim()
    .regex(/^0\d([\d-]){7,11}$/, "מספר טלפון לא תקין"),
});

function Landing() {
  const [variant, setVariant] = useState<DisplayVariant>("barlev");
  useEffect(() => {
    try {
      const saved = localStorage.getItem("md-display-variant") as DisplayVariant | null;
      if (saved === "anomalia" || saved === "barlev") setVariant(saved);
    } catch {}
  }, []);
  const toggleVariant = () => {
    setVariant((v) => {
      const next: DisplayVariant = v === "barlev" ? "anomalia" : "barlev";
      try { localStorage.setItem("md-display-variant", next); } catch {}
      return next;
    });
  };
  return (
    <div
      className="bg-white text-neutral-900 min-h-screen pb-28 md:pb-0 selection:bg-[#ff7a00] selection:text-black overflow-x-hidden antialiased"
      style={{ ...fontBody, ["--md-display" as never]: DISPLAY_STACKS[variant] }}
    >
      <style>{`
        @keyframes md-fade-up { 0% { opacity: 0; transform: translateY(24px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes md-fade-in { 0% { opacity: 0; } 100% { opacity: 1; } }
        @keyframes md-slide-right { 0% { opacity: 0; transform: translateX(28px); } 100% { opacity: 1; transform: translateX(0); } }
        @keyframes md-pop { 0% { opacity: 0; transform: scale(.92); } 100% { opacity: 1; transform: scale(1); } }
        .md-reveal { opacity: 0; animation: md-fade-up .8s ease-out forwards; }
        .md-reveal-in { opacity: 0; animation: md-fade-in 1s ease-out forwards; }
        .md-reveal-right { opacity: 0; animation: md-slide-right .8s ease-out forwards; }
        .md-reveal-pop { opacity: 0; animation: md-pop .6s cubic-bezier(.2,.8,.2,1) forwards; }
        .md-card-hover { transition: transform .35s cubic-bezier(.2,.8,.2,1), box-shadow .35s ease, border-color .35s ease, background-color .35s ease; }
        .md-card-hover:hover { transform: translateY(-6px); }
        .md-img-hover img { transition: transform .8s cubic-bezier(.2,.8,.2,1); }
        .md-img-hover:hover img { transform: scale(1.06); }

        /* Premium button hover — shine sweep + glow lift */
        .md-btn { position: relative; overflow: hidden; isolation: isolate; transition: transform .3s cubic-bezier(.2,.8,.2,1), box-shadow .35s ease, filter .35s ease; }
        .md-btn:hover { transform: translateY(-2px); filter: brightness(1.05); }
        .md-btn:active { transform: translateY(0); }
        .md-btn::before {
          content: ""; position: absolute; inset: 0; z-index: -1;
          background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,.55) 50%, transparent 70%);
          transform: translateX(-120%); transition: transform .8s ease;
        }
        .md-btn:hover::before { transform: translateX(120%); }

        /* Outline / ghost button hover */
        .md-btn-ghost { transition: background-color .3s ease, border-color .3s ease, transform .3s ease, color .3s ease; }
        .md-btn-ghost:hover { transform: translateY(-2px); }

        @media (prefers-reduced-motion: reduce) {
          .md-reveal,.md-reveal-in,.md-reveal-right,.md-reveal-pop { animation: none; opacity: 1; }
          .md-btn::before { display: none; }
        }
      `}</style>
      <Toaster position="top-center" richColors />
      <Header />
      <Hero />
      <TrustBar />
      <Identify />
      <Solution />
      <WhoIsItFor />
      <ContactStrip />
      <WhyUs />
      <Process />
      <Testimonials />
      <SuccessBlock />
      <LeadFormSection />
      <BottomCTA />
      <Footer />
      <FloatingWhatsApp />
      <FloatingEligibility />
      <StickyBottomBar />
      <VariantToggle variant={variant} onToggle={toggleVariant} />
    </div>
  );
}

/* --------------------------- variant font toggle -------------------------- */
function VariantToggle({ variant, onToggle }: { variant: DisplayVariant; onToggle: () => void }) {
  const isAnomalia = variant === "anomalia";
  return (
    <button
      type="button"
      onClick={onToggle}
      aria-label="החלפת גרסת פונט כותרות"
      className="fixed z-[60] top-20 left-3 md:top-24 md:left-5 flex items-center gap-2 px-3.5 py-2 rounded-full text-[12px] font-bold border shadow-lg backdrop-blur transition-all hover:scale-105"
      style={{
        background: "rgba(10,10,10,0.92)",
        color: "#fff",
        borderColor: "rgba(255,122,0,0.5)",
        boxShadow: `0 10px 30px -10px ${ORANGE}99`,
      }}
    >
      <span className="opacity-70">פונט:</span>
      <span style={{ fontFamily: DISPLAY_STACKS[variant], color: ORANGE }}>
        {isAnomalia ? "Anomalia" : "Barlev"}
      </span>
      <span className="opacity-50">⇄</span>
    </button>
  );
}


/* --------------------------------- header --------------------------------- */
function Header() {
  return (
    <nav className="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-neutral-200 px-5 md:px-10 py-2 flex justify-between items-center">
      <a href="#top" className="flex items-center gap-3 group">
        <img
          src={logoAsset.url}
          alt="מטאדוק - נדל״ן, מימון, פיננסים"
          width={260}
          height={100}
          className="h-14 md:h-16 w-auto object-contain transition-transform group-hover:scale-[1.04]"
        />
      </a>
      <div className="flex items-center gap-2">
        <a
          href={`tel:${PHONE_TEL}`}
          className="hidden md:inline-flex items-center gap-2 text-sm font-bold text-neutral-700 hover:text-neutral-900 transition"
        >
          <Phone className="size-4" style={{ color: ORANGE }} />
          {PHONE_DISPLAY}
        </a>
        <a
          href="#form"
          className="md-btn text-white px-4 py-2 rounded-full text-sm font-extrabold flex items-center gap-1.5 shadow-sm"
          style={{ background: INK }}
        >
          בדיקת זכאות
          <ArrowLeft className="size-3.5" />
        </a>
      </div>
    </nav>
  );
}

/* ---------------------------------- hero ---------------------------------- */
function Hero() {
  return (
    <header className="relative overflow-hidden bg-black text-white">
      {/* decorative */}
      <div
        className="absolute inset-0 opacity-[0.04] pointer-events-none"
        style={{
          backgroundImage:
            "linear-gradient(to right, white 1px, transparent 1px), linear-gradient(to bottom, white 1px, transparent 1px)",
          backgroundSize: "44px 44px",
        }}
        aria-hidden
      />
      {/* orange glow blobs */}
      <div
        className="absolute -left-32 top-10 w-[26rem] h-[26rem] rounded-full blur-[140px] opacity-25"
        style={{ background: ORANGE }}
        aria-hidden
      />
      <div
        className="absolute -right-40 bottom-0 w-[22rem] h-[22rem] rounded-full blur-[120px] opacity-10"
        style={{ background: "#3b82f6" }}
        aria-hidden
      />

      {/* Metadoc logo watermark with orange halo */}
      <div
        className="absolute -right-10 top-1/2 -translate-y-1/2 opacity-[0.07] pointer-events-none select-none"
        aria-hidden
      >
        <img
          src={logoAsset.url}
          alt=""
          width={600}
          height={220}
          className="w-[28rem] md:w-[36rem] lg:w-[44rem] h-auto object-contain"
          style={{
            filter: `drop-shadow(0 0 40px ${ORANGE}cc) drop-shadow(0 0 80px ${ORANGE}99)`,
          }}
        />
      </div>

      <div className="relative z-10 max-w-7xl mx-auto px-6 md:px-10 pt-12 md:pt-20 pb-14 md:pb-24 grid md:grid-cols-12 gap-10 items-center">
        {/* Text */}
        <div className="md:col-span-7">
          <div className="flex items-center gap-3 mb-6">
            <span className="h-px w-10" style={{ background: ORANGE }} />
            <span
              className="text-[11px] md:text-[13px] font-bold tracking-[0.25em]"
              style={{ color: ORANGE_SOFT }}
            >
              מומחי משכנתאות · מעל 15 שנות ניסיון
            </span>
          </div>

          <h1
            className="md-reveal text-[2.6rem] sm:text-[3.2rem] md:text-[4.2rem] lg:text-[4.8rem] leading-[1] font-bold mb-6 tracking-tight text-balance"
            style={{ ...fontDisplay, animationDelay: "60ms" }}
          >
            סורבתם למשכנתא?
            <br />
            <span style={{ color: ORANGE }}>אל תוותרו.</span>
          </h1>

          <div className="md-reveal text-[16px] md:text-[18px] text-white/75 mb-7 leading-relaxed max-w-[54ch] text-balance" style={{ animationDelay: "180ms" }}>
            <p>
              מעל 15 שנות ניסיון במציאת פתרונות מימון לבעלי נכסים ולרוכשי דירות שנתקלו בסירוב מהבנק ובהליכי מימון מורכבים.
            </p>
          </div>

          <div className="md-reveal flex flex-col sm:flex-row gap-3 mb-8" style={{ animationDelay: "300ms" }}>
            <a
              href="#form"
              className="md-btn group text-black text-center px-7 py-4 rounded-xl text-base md:text-lg font-black flex items-center justify-center gap-2"
              style={{
                background: `linear-gradient(135deg, ${ORANGE} 0%, ${ORANGE_SOFT} 100%)`,
                boxShadow: `0 18px 40px -12px ${ORANGE}cc`,
              }}
            >
              בדיקת זכאות חינם
              <ArrowLeft className="size-5 group-hover:-translate-x-1 transition-transform" />
            </a>
            <a
              href={`tel:${PHONE_TEL}`}
              className="md-btn-ghost text-white text-center px-7 py-4 rounded-xl text-base md:text-lg font-bold border border-white/20 hover:bg-white/10 hover:border-white/50 flex items-center justify-center gap-2"
            >
              <Phone className="size-4" />
              {PHONE_DISPLAY}
            </a>
          </div>

          <div className="md-reveal flex items-center gap-4 text-[12px] text-white/60" style={{ animationDelay: "420ms" }}>
            <span className="flex items-center gap-1.5">
              <ShieldCheck className="size-4" style={{ color: ORANGE_SOFT }} />
              ללא התחייבות
            </span>
            <span className="w-1 h-1 rounded-full bg-white/20" />
            <span>דיסקרטיות מלאה</span>
            <span className="w-1 h-1 rounded-full bg-white/20" />
            <span>מענה תוך 24ש׳</span>
          </div>
        </div>

        {/* Image card */}
        <div className="md:col-span-5 md-reveal-right" style={{ animationDelay: "240ms" }}>
          <figure className="relative rounded-3xl overflow-hidden border border-white/10 shadow-[0_40px_80px_-20px_rgba(0,0,0,0.6)] group md-img-hover">
            <img
              src={rejectionImg}
              alt="לקוח שמקבל מכתב סירוב מהבנק"
              width={1024}
              height={1024}
              className="w-full h-[320px] md:h-[460px] object-cover transition-transform duration-700 group-hover:scale-105"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent" />
            <figcaption className="absolute inset-x-0 bottom-0 p-5 md:p-6">
              <div
                className="text-[10px] tracking-[0.3em] uppercase font-bold mb-1.5"
                style={{ color: ORANGE_SOFT }}
              >
                כשכולם אומרים "אי אפשר"
              </div>
              <div className="text-lg md:text-xl font-bold leading-tight" style={fontDisplay}>
                – אנחנו מתחילים לבדוק איך כן
              </div>
            </figcaption>
            {/* floating stat */}
            <div className="absolute top-4 right-4 bg-white/95 backdrop-blur rounded-2xl px-4 py-3 text-neutral-900 shadow-xl">
              <div className="text-2xl font-black leading-none" style={fontDisplay}>
                94%
              </div>
              <div className="text-[10px] font-bold text-neutral-500 tracking-wider uppercase mt-1">
                מהתיקים מקבלים פתרון
              </div>
            </div>
          </figure>
        </div>
      </div>
    </header>
  );
}

/* --------------------------------- trust bar ------------------------------ */
function TrustBar() {
  const stats = [
    { icon: Clock, n: "+15", t: "מעל 15 שנות ניסיון" },
    { icon: Users, n: "+800", t: "לקוחות מרוצים" },
    { icon: Award, n: "94%", t: "אחוזי הצלחה" },
    { icon: ShieldCheck, n: "100%", t: "דיסקרטיות" },
  ];
  return (
    <section className="bg-white border-b border-neutral-200">
      <div className="max-w-7xl mx-auto px-6 md:px-10 py-6 md:py-8 grid grid-cols-2 md:grid-cols-4 gap-6">
        {stats.map(({ icon: Icon, n, t }) => (
          <div key={t} className="flex items-center gap-3">
            <div
              className="size-11 rounded-xl grid place-items-center shrink-0 border border-neutral-200"
              style={{ background: "#fff7ee" }}
            >
              <Icon className="size-5" style={{ color: ORANGE }} />
            </div>
            <div className="min-w-0">
              <div className="text-xl md:text-2xl font-black leading-none text-neutral-900" style={fontDisplay}>
                {n}
              </div>
              <div className="text-[11px] md:text-xs font-semibold text-neutral-500 tracking-wide mt-1">
                {t}
              </div>
            </div>
          </div>
        ))}
      </div>
    </section>
  );
}

/* -------------------------------- identify -------------------------------- */
function Identify() {
  const items = [
    "הבקשה למשכנתא נדחתה",
    "סירוב מהבנק בגלל התנהלות חשבון",
    "חזרו צ'קים או הוראות קבע בעבר",
    "דירוג האשראי פוגע בסיכויי האישור",
    "ריבוי הלוואות והחזרים חודשיים גבוהים",
    "אין מי שמוכן להילחם עבורכם",
  ];
  return (
    <section className="bg-neutral-50 relative">
      <div className="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24 grid md:grid-cols-12 gap-10 items-start">
        <div className="md:col-span-5 md:sticky md:top-24">
          <SectionLabel num="01" eyebrow="נשמע מוכר?" />
          <SectionHeading>
            אם הגעתם לכאן —<br />
            <span style={{ color: ORANGE }}>אתם לא לבד</span>.
          </SectionHeading>
          <p className="text-neutral-600 leading-relaxed text-[15px] md:text-base max-w-[42ch] mt-5">
            אנחנו פוגשים מדי חודש אנשים טובים, עובדים ומתפרנסים, שנדחים פעם אחר
            פעם — למרות שיש להם נכס, הכנסה ויכולת החזר.
          </p>
          <p className="text-neutral-600 leading-relaxed text-[15px] md:text-base max-w-[42ch] mt-3 font-semibold">
            אנחנו כאן כדי לפתוח דלתות גם כשנראה שאין סיכוי.
          </p>
        </div>

        <ul className="md:col-span-7 grid sm:grid-cols-2 gap-3">
          {items.map((t, i) => (
            <li
              key={t}
              className="group flex gap-4 items-start bg-white hover:border-neutral-900 border border-neutral-200 rounded-2xl px-5 py-4 transition-all hover:shadow-md"
            >
              <span
                className="text-sm font-black tabular-nums text-neutral-300 group-hover:text-[color:var(--orange)] transition w-6 mt-0.5"
                style={{ ["--orange" as never]: ORANGE, ...fontDisplay }}
              >
                0{i + 1}
              </span>
              <span className="text-[15px] text-neutral-800 leading-snug font-medium flex-1">
                {t}
              </span>
              <Check className="size-5 mt-0.5 shrink-0" style={{ color: ORANGE }} />
            </li>
          ))}
        </ul>
      </div>
    </section>
  );
}

/* ------------------------------- who is it for ---------------------------- */
function WhoIsItFor() {
  const audiences = [
    { icon: Home, t: "דירה ראשונה", d: "זוגות צעירים ומשפחות שרוכשים נכס ראשון וצריכים ליווי מקצועי" },
    { icon: Building2, t: "מחזור משכנתא", d: "בעלי נכס קיים שרוצים לשפר תנאים, להוריד ריבית או למשוך הון" },
    { icon: Landmark, t: "נדחו על ידי הבנק", d: "מי שסבל מסירוב בנקאי וזקוק למומחה שיודע איך לפתוח דלתות" },
    { icon: Briefcase, t: "עצמאיים ובעלי עסקים", d: "לקוחות עם הכנסה משתנה שבנקים רואים בה כאתגר" },
    { icon: TrendingDown, t: "ריבוי התחייבויות", d: "בעלי הלוואות וחובות מרובים המעונינים לאחד הלוואות ולשפר את ההחזרים" },
    { icon: Wallet, t: "נכס להשקעה", d: "מי שמעוניין לרכוש דירה להשקעה וזקוק למסלול מימון מתאים" },
  ];
  return (
    <section className="bg-white relative overflow-hidden">
      {/* subtle orange glow */}
      <div
        className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[36rem] h-[36rem] rounded-full blur-[160px] opacity-[0.06]"
        style={{ background: ORANGE }}
        aria-hidden
      />
      <div className="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24 relative">
        <div className="max-w-3xl mb-12 md:mb-16">
          <SectionLabel num="03" eyebrow="למי מתאים השירות" />
          <SectionHeading>
            אם יש לכם נכס או אתם בתהליך רכישה —<br />
            <span style={{ color: ORANGE }}>אתם מתאימים!</span>
          </SectionHeading>
        </div>

        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
          {audiences.map((a, i) => {
            const Icon = a.icon;
            return (
              <div
                key={a.t}
                className="md-card-hover md-reveal group bg-neutral-50 border border-neutral-200 rounded-2xl p-6 md:p-7 hover:bg-white hover:shadow-[0_24px_60px_-30px_rgba(0,0,0,0.2)] hover:border-neutral-300 flex flex-col"
                style={{ animationDelay: `${i * 90}ms` }}
              >
                <div
                  className="size-12 rounded-xl grid place-items-center mb-4 border"
                  style={{
                    background: "rgba(255,122,0,0.08)",
                    borderColor: "rgba(255,122,0,0.25)",
                  }}
                >
                  <Icon className="size-6" style={{ color: ORANGE }} strokeWidth={1.6} />
                </div>
                <h3 className="font-bold text-xl md:text-2xl leading-[1.1] mb-2 text-neutral-900 tracking-tight" style={fontDisplay}>
                  {a.t}
                </h3>
                <p className="text-[14px] md:text-[15px] text-neutral-600 leading-relaxed">{a.d}</p>
              </div>
            );
          })}
        </div>
      </div>
    </section>
  );
}

/* ------------------------------ contact strip ----------------------------- */
function ContactStrip() {
  const [submitting, setSubmitting] = useState(false);

  function onSubmit(e: FormEvent<HTMLFormElement>) {
    e.preventDefault();
    const form = e.currentTarget;
    const data = new FormData(form);
    const parsed = leadSchema.safeParse({
      name: data.get("name"),
      phone: data.get("phone"),
    });
    if (!parsed.success) {
      toast.error(parsed.error.issues[0]?.message ?? "נא לבדוק את הפרטים");
      return;
    }
    setSubmitting(true);
    setTimeout(() => {
      setSubmitting(false);
      toast.success("הפרטים נשלחו! מומחה יחזור אליכם בהקדם.");
      form.reset();
    }, 700);
  }

  const inputCls =
    "w-full bg-white border border-white/20 rounded-xl px-4 py-3 focus:outline-none focus:border-[#ff7a00] placeholder:text-neutral-400 text-neutral-900 text-[15px] transition-colors shadow-sm";

  return (
    <section className="bg-black text-white border-y border-white/10 relative overflow-hidden">
      <div
        className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[34rem] h-[34rem] rounded-full blur-[160px] opacity-20"
        style={{ background: ORANGE }}
        aria-hidden
      />
      <div className="max-w-7xl mx-auto px-6 md:px-10 py-6 md:py-8 relative">
        <h3
          className="text-center text-2xl md:text-3xl font-bold mb-5 tracking-tight"
          style={fontDisplay}
        >
          צרו קשר לבדיקת זכאות <span style={{ color: ORANGE }}>ללא עלות</span>
        </h3>
        <form onSubmit={onSubmit} className="grid md:grid-cols-12 gap-3 items-end" noValidate>
          <div className="md:col-span-3">
            <input
              name="name"
              type="text"
              required
              className={inputCls}
              placeholder="שם מלא"
              aria-label="שם מלא"
            />
          </div>
          <div className="md:col-span-3">
            <input
              name="phone"
              type="tel"
              inputMode="tel"
              required
              className={inputCls}
              placeholder="טלפון"
              aria-label="טלפון"
            />
          </div>
          <div className="md:col-span-4">
            <input
              name="note"
              type="text"
              className={inputCls}
              placeholder="פרטים נוספים (לא חובה)"
              aria-label="פרטים נוספים"
            />
          </div>
          <div className="md:col-span-2">
            <button
              type="submit"
              disabled={submitting}
              className="md-btn w-full text-black font-extrabold py-3 rounded-xl text-[15px] disabled:opacity-60 flex items-center justify-center gap-2"
              style={{
                background: `linear-gradient(135deg, ${ORANGE} 0%, ${ORANGE_SOFT} 100%)`,
              }}
            >
              {submitting ? "שולח..." : (
                <>
                  שלחו <ArrowLeft className="size-4" />
                </>
              )}
            </button>
          </div>
        </form>
        <p className="text-[11px] text-white/50 mt-3 text-center flex items-center justify-center gap-1.5">
          <ShieldCheck className="size-3" />
          ללא התחייבות · דיסקרטיות מלאה · מענה תוך 24 שעות
        </p>
      </div>
    </section>
  );
}

/* -------------------------------- solution -------------------------------- */
function Solution() {
  return (
    <section className="bg-black text-white relative overflow-hidden">
      <div
        className="absolute top-0 right-0 w-80 h-80 rounded-full blur-[120px] opacity-20"
        style={{ background: ORANGE }}
        aria-hidden
      />
      <div
        className="absolute -bottom-20 -left-20 w-[24rem] h-[24rem] rounded-full blur-[140px] opacity-15"
        style={{ background: ORANGE }}
        aria-hidden
      />

      {/* Metadoc logo watermark with orange halo */}
      <div
        className="absolute -left-6 top-1/2 -translate-y-1/2 opacity-[0.06] pointer-events-none select-none"
        aria-hidden
      >
        <img
          src={logoAsset.url}
          alt=""
          width={600}
          height={220}
          className="w-[24rem] md:w-[30rem] lg:w-[36rem] h-auto object-contain"
          style={{
            filter: `drop-shadow(0 0 30px ${ORANGE}cc) drop-shadow(0 0 60px ${ORANGE}99)`,
          }}
        />
      </div>

      <div className="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24 grid md:grid-cols-12 gap-10 items-center relative">
        <figure className="md:col-span-6 rounded-3xl overflow-hidden border border-white/10 relative group order-2 md:order-1 shadow-[0_40px_80px_-20px_rgba(0,0,0,0.6)]">
          <img
            src={handshakeImg}
            alt="יועץ משכנתאות לוחץ ידיים עם לקוח"
            loading="lazy"
            width={1024}
            height={1024}
            className="w-full h-[300px] md:h-[460px] object-cover transition-transform duration-700 group-hover:scale-105"
          />
          {/* Metadoc logo watermark on office background */}
          <div className="absolute inset-0 flex items-center justify-center pointer-events-none select-none">
            <img
              src={logoAsset.url}
              alt=""
              width={600}
              height={220}
              className="w-[70%] h-auto object-contain opacity-[0.08]"
              style={{
                filter: `drop-shadow(0 0 20px ${ORANGE}99)`,
              }}
            />
          </div>
          <div className="absolute inset-x-0 bottom-0 p-5 bg-gradient-to-t from-black via-black/50 to-transparent">
            <div
              className="text-[10px] uppercase tracking-[0.3em] font-bold"
              style={{ color: ORANGE_SOFT }}
            >
              שותפים · לא ספקים
            </div>
          </div>
        </figure>

        <div className="md:col-span-6 order-1 md:order-2">
          <SectionLabel num="02" eyebrow="הפתרון" dark />
          <SectionHeading className="text-white">
            פתרונות המימון שלנו מתאימים במיוחד<br />
            <span style={{ color: ORANGE }}>למצבים כאלו</span>.
          </SectionHeading>

          <div className="space-y-5 text-[15px] md:text-[16px] text-white/75 leading-relaxed mt-6">
            <p>
              במשך יותר מ-15 שנים אנו מלווים לקוחות במצבים מורכבים מול גופי המימון
              והבנקים — כאלה שכבר שמעו "לא" יותר מפעם אחת.
            </p>
            <p>
              אנחנו בוחנים כל תיק לעומק, מזהים את החסמים האמיתיים, בונים
              אסטרטגיית מימון יצירתית ומלווים אתכם לאורך כל הדרך עד החתימה.
            </p>
            <p
              className="text-white font-bold border-r-2 pr-5 text-[19px] md:text-[24px] leading-relaxed"
              style={{ borderColor: ORANGE, ...fontDisplay }}
            >
              המטרה שלנו פשוטה: למצות עבורכם את כל האפשרויות הקיימות
              <br />
              ולהביא לפתרון המימון המתאים ביותר.
            </p>
          </div>
        </div>
      </div>
    </section>
  );
}

/* --------------------------------- why us --------------------------------- */
function WhyUs() {
  const points = [
    { t: "ניסיון של מעל 15 שנים", d: "ידע מעשי בטיפול בתיקים מורכבים ובמקרים שנדחו בעבר על ידי שני בנקים ויותר." },
    { t: "נלחמים על כל לקוח", d: "לא מסתפקים בתשובה הראשונה. ממשיכים לבדוק עד שמוצאים את הפתרון הנכון." },
    { t: "מומחיות במקרים מורכבים", d: "לקוחות בעלי אתגרי אשראי, סירובי בנקים, BDI שלילי ותיקים חריגים." },
    { t: "ליווי אישי וצמוד", d: "איש קשר אחד שמכיר את התיק שלכם לעומק, מההתחלה ועד לחתימה." },
    { t: "מאות לקוחות מרוצים", d: "אנשים שכבר היו בטוחים שאין להם פתרון – וקיבלו הזדמנות נוספת." },
    { t: "שקיפות מלאה", d: "אתם תמיד יודעים בדיוק איפה התיק עומד, מה הצעדים הבאים והעלויות הצפויות." },
  ];
  return (
    <section className="bg-white">
      <div className="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24">
        <div className="max-w-3xl mb-12 md:mb-16">
          <SectionLabel num="04" eyebrow="למה דווקא מטאדוק" />
          <SectionHeading>
            כי הניסיון<br />
            <span style={{ color: ORANGE }}>עושה את ההבדל</span>.
          </SectionHeading>
        </div>

        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-px bg-neutral-200 border border-neutral-200 rounded-3xl overflow-hidden">
          {points.map((p, i) => (
            <div
              key={p.t}
              className="md-card-hover md-reveal group bg-white p-7 md:p-9 hover:bg-neutral-50 hover:shadow-[0_24px_60px_-30px_rgba(0,0,0,0.35)] flex flex-col"
              style={{ animationDelay: `${i * 90}ms` }}
            >
              <div className="flex items-baseline gap-3 mb-4">
                <div
                  className="text-3xl md:text-4xl font-black tabular-nums leading-none"
                  style={{ ...fontDisplay, color: ORANGE }}
                >
                  {String(i + 1).padStart(2, "0")}
                </div>
                <div className="h-px flex-1 bg-neutral-200 group-hover:bg-[color:var(--c)] transition-colors" style={{ ["--c" as never]: ORANGE }} />
              </div>
              <h3 className="font-bold text-2xl md:text-[1.75rem] leading-[1.1] mb-3 text-neutral-900 tracking-tight" style={fontDisplay}>
                {p.t}
              </h3>
              <p className="text-[14px] md:text-[15px] text-neutral-600 leading-relaxed">{p.d}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

/* --------------------------------- process -------------------------------- */
function Process() {
  const steps: { icon: LucideIcon; t: string; d: string }[] = [
    { icon: PenLine, t: "משאירים פרטים", d: "נציג מומחה יוצר איתכם קשר בהקדם לשיחת בדיקה ראשונית." },
    { icon: Search, t: "בודקים את המקרה", d: "אנחנו מנתחים את כל הנתונים ומבינים בדיוק מה גרם לסירוב." },
    { icon: Lightbulb, t: "בונים פתרון", d: "מתאימים את מסלול הפעולה הנכון והיצירתי ביותר עבורכם." },
    { icon: HeartHandshake, t: "מלווים עד לסיום", d: "נמצאים לצידכם מהשלב הראשון ועד הרגע של קבלת הכסף לחשבון" },
  ];
  return (
    <section
      className="relative overflow-hidden text-white"
      style={{
        background:
          "radial-gradient(1200px 600px at 85% -10%, rgba(255,122,0,0.25), transparent 60%), radial-gradient(900px 500px at 0% 100%, rgba(255,122,0,0.18), transparent 55%), linear-gradient(180deg, #0f0f10 0%, #161618 100%)",
      }}
    >
      <div
        className="absolute inset-0 opacity-[0.07]"
        aria-hidden
        style={{
          backgroundImage:
            "linear-gradient(to right, white 1px, transparent 1px), linear-gradient(to bottom, white 1px, transparent 1px)",
          backgroundSize: "44px 44px",
        }}
      />
      <div
        className="absolute -top-24 -right-24 w-[28rem] h-[28rem] rounded-full blur-[140px] opacity-30"
        style={{ background: ORANGE }}
        aria-hidden
      />
      <div className="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24 relative">
        <div
          className="inline-flex items-center gap-2 mb-5 px-4 py-2 rounded-full border border-white/15 bg-white/5 backdrop-blur"
        >
          <span className="size-1.5 rounded-full" style={{ background: ORANGE }} />
          <span className="text-[11px] md:text-[12px] font-bold tracking-[0.3em] uppercase text-white/80">
            התהליך · 4 שלבים פשוטים
          </span>
        </div>
        <h2
          className="text-[2.6rem] sm:text-5xl md:text-6xl lg:text-[4.2rem] leading-[0.95] font-bold tracking-tight text-white mb-12 md:mb-16"
          style={fontDisplay}
        >
          איך זה{" "}
          <span className="relative inline-block">
            <span className="relative z-10" style={{ color: ORANGE }}>עובד</span>
            <span className="absolute inset-x-0 bottom-1 h-3 md:h-4 bg-white/10 -z-0" />
          </span>
          ?
        </h2>

        <div className="grid md:grid-cols-4 gap-5">
          {steps.map((s, idx) => {
            const Icon = s.icon;
            return (
              <div
                key={s.t}
                className="md-card-hover md-reveal-pop relative bg-white/[0.04] backdrop-blur border border-white/10 text-white rounded-2xl p-6 md:p-8 hover:bg-white/[0.07] hover:border-white/20 hover:shadow-[0_30px_60px_-20px_rgba(255,122,0,0.35)]"
                style={{ animationDelay: `${idx * 120}ms` }}
              >
                <div
                  className="size-14 rounded-2xl grid place-items-center mb-5 border transition-transform duration-500 group-hover:rotate-6"
                  style={{
                    background: "rgba(255,122,0,0.10)",
                    borderColor: "rgba(255,122,0,0.35)",
                    boxShadow: "inset 0 0 0 1px rgba(255,255,255,0.04)",
                  }}
                >
                  <Icon className="size-7" style={{ color: ORANGE }} strokeWidth={1.6} />
                </div>
                <h3 className="font-bold text-2xl md:text-[1.75rem] leading-[1.1] mb-3 tracking-tight" style={fontDisplay}>
                  {s.t}
                </h3>
                <p className="text-white/70 text-[14px] md:text-[15px] leading-relaxed">{s.d}</p>
                {idx < steps.length - 1 && (
                  <ArrowLeft className="hidden md:block absolute -left-4 top-1/2 -translate-y-1/2 size-5 text-white/30" />
                )}
              </div>
            );
          })}
        </div>
      </div>
    </section>
  );
}

/* ------------------------------- testimonials ----------------------------- */
function Testimonials() {
  const t = [
    {
      n: "יעקב ל.",
      city: "בני ברק",
      q: "סורבתי בשני בנקים. במטאדוק מצאו לי פתרון תוך 3 שבועות. שירות אישי לאורך כל הדרך.",
    },
    {
      n: "מרים פ.",
      city: "מודיעין עילית",
      q: "חשבתי שאין סיכוי שאקבל משכנתא. הם לא ויתרו עד שמצאו את המסלול הנכון בשבילי.",
    },
    {
      n: "דוד א.",
      city: "אשדוד",
      q: "אחרי שלוש שנים של ניסיונות, תוך חודש היה לנו אישור. אנשי מקצוע אמיתיים.",
    },
  ];
  return (
    <section className="bg-neutral-50 border-y border-neutral-200">
      <div className="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24">
        <SectionLabel num="05" eyebrow="מה אומרים עלינו" />
        <SectionHeading>
          אנשים שהיו <span style={{ color: ORANGE }}>בדיוק במקומכם</span>.
        </SectionHeading>

        <div className="grid md:grid-cols-3 gap-5 mt-12">
          {t.map((item) => (
            <figure
              key={item.n}
              className="bg-white border border-neutral-200 rounded-2xl p-6 md:p-7 flex flex-col hover:shadow-lg transition-shadow"
            >
              <div className="flex items-center gap-1 mb-4" style={{ color: ORANGE }}>
                {Array.from({ length: 5 }).map((_, i) => (
                  <Star key={i} className="size-4 fill-current" />
                ))}
              </div>
              <blockquote className="text-[15px] md:text-base text-neutral-800 leading-relaxed mb-6 flex-1" style={fontBody}>
                "{item.q}"
              </blockquote>
              <figcaption className="flex items-center gap-3 pt-4 border-t border-neutral-100">
                <div
                  className="size-10 rounded-full grid place-items-center text-sm font-black text-black shrink-0"
                  style={{ background: ORANGE }}
                >
                  {item.n[0]}
                </div>
                <div className="leading-tight">
                  <div className="text-sm font-bold text-neutral-900">{item.n}</div>
                  <div className="text-[11px] text-neutral-500 mt-0.5">{item.city}</div>
                </div>
              </figcaption>
            </figure>
          ))}
        </div>
      </div>
    </section>
  );
}

/* ------------------------------- success block ---------------------------- */
function SuccessBlock() {
  return (
    <section className="bg-white">
      <div className="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24">
        <figure className="rounded-3xl overflow-hidden border border-neutral-200 shadow-[0_40px_80px_-30px_rgba(0,0,0,0.25)] grid md:grid-cols-2 bg-white">
          <div className="relative">
            <img
              src={familyImg}
              alt="משפחה מאושרת מקבלת מפתחות לבית חדש"
              loading="lazy"
              width={1024}
              height={1024}
              className="w-full h-[280px] md:h-full object-cover"
            />
            <div className="absolute top-5 right-5 bg-black/85 backdrop-blur text-white text-[10px] font-bold tracking-[0.3em] uppercase px-3 py-1.5 rounded-full">
              סיפור הצלחה
            </div>
          </div>
          <div className="p-8 md:p-12 flex flex-col justify-center">
            <SectionLabel num="06" eyebrow="זה אפשרי" />
            <h3
              className="text-[2rem] md:text-[2.6rem] leading-[1.05] font-bold mb-5 text-neutral-900 tracking-tight"
              style={fontDisplay}
            >
              הם כבר קיבלו את{" "}
              <span style={{ color: ORANGE }}>המפתחות</span>.<br />
              תורכם.
            </h3>
            <p className="text-neutral-600 text-[15px] md:text-base leading-relaxed mb-6">
              מאות משפחות שכבר התייאשו מצאו אצלנו פתרון מימון אמיתי — וקיבלו את
              הבית, את ההלוואה ואת השקט הנפשי שמגיע להם.
            </p>
            <a
              href="#form"
              className="md-btn self-start text-black px-6 py-3.5 rounded-xl text-base font-black flex items-center gap-2"
              style={{
                background: `linear-gradient(135deg, ${ORANGE} 0%, ${ORANGE_SOFT} 100%)`,
                boxShadow: `0 16px 36px -10px ${ORANGE}b3`,
              }}
            >
              בדקו את התיק שלכם
              <ArrowLeft className="size-4" />
            </a>
          </div>
        </figure>
      </div>
    </section>
  );
}

/* ----------------------------------- form --------------------------------- */
function LeadFormSection() {
  return (
    <section id="form" className="bg-neutral-50">
      <div className="max-w-7xl mx-auto px-6 md:px-10 py-16 md:py-24 grid md:grid-cols-12 gap-10 items-start">
        <div className="md:col-span-5">
          <SectionLabel num="07" eyebrow="בדיקת זכאות" />
          <SectionHeading>
            ללא עלות.<br />
            <span style={{ color: ORANGE }}>ללא התחייבות.</span>
          </SectionHeading>
          <p className="text-neutral-600 leading-relaxed text-[15px] md:text-base mt-5 mb-7 max-w-[42ch]">
            השאירו פרטים, מומחה מהצוות שלנו יחזור אליכם תוך 24 שעות לשיחת בדיקה
            ראשונית — אישית, חינמית, ובלי שום התחייבות מצדכם.
          </p>

          <ul className="space-y-3 text-[14px] text-neutral-700">
            {["בדיקה ראשונית מקצועית", "ליווי אישי וצמוד", "ניסיון של מעל 15 שנים", "דיסקרטיות מוחלטת"].map((b) => (
              <li key={b} className="flex items-center gap-2.5">
                <Check className="size-4 shrink-0" style={{ color: ORANGE }} />
                <span className="font-medium">{b}</span>
              </li>
            ))}
          </ul>
        </div>

        <div className="md:col-span-7 w-full">
          <div className="bg-black text-white rounded-3xl px-6 md:px-10 py-8 md:py-10 shadow-2xl relative overflow-hidden border border-white/10">
            <div
              className="absolute -top-16 -left-16 w-60 h-60 rounded-full blur-3xl opacity-25"
              style={{ background: ORANGE }}
              aria-hidden
            />
            <div className="relative">
              <div className="text-[10px] font-bold tracking-[0.35em] uppercase mb-3" style={{ color: ORANGE_SOFT }}>
                טופס בדיקת זכאות
              </div>
              <h2 className="text-2xl md:text-3xl font-bold mb-6 tracking-tight" style={fontDisplay}>
                השאירו פרטים — נחזור אליכם תוך 24 שעות.
              </h2>
              <LeadForm />
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

function LeadForm() {
  const [submitting, setSubmitting] = useState(false);

  function onSubmit(e: FormEvent<HTMLFormElement>) {
    e.preventDefault();
    const form = e.currentTarget;
    const data = new FormData(form);
    const parsed = leadSchema.safeParse({
      name: data.get("name"),
      phone: data.get("phone"),
    });
    if (!parsed.success) {
      toast.error(parsed.error.issues[0]?.message ?? "נא לבדוק את הפרטים");
      return;
    }
    setSubmitting(true);
    setTimeout(() => {
      setSubmitting(false);
      toast.success("הפרטים נשלחו! מומחה יחזור אליכם בהקדם.");
      form.reset();
    }, 700);
  }

  const inputCls =
    "w-full bg-white/5 border border-white/15 rounded-xl px-4 py-3.5 focus:outline-none focus:border-[#ff7a00] focus:bg-white/10 placeholder:text-white/35 text-white transition-colors";

  return (
    <form className="space-y-4" onSubmit={onSubmit} noValidate>
      <div className="grid sm:grid-cols-2 gap-4">
        <Field label="שם מלא" htmlFor="name">
          <input id="name" name="name" type="text" className={inputCls} placeholder="ישראל ישראלי" />
        </Field>
        <Field label="טלפון" htmlFor="phone">
          <input id="phone" name="phone" type="tel" inputMode="tel" className={inputCls} placeholder={PHONE_DISPLAY} />
        </Field>
      </div>
      <Field label="פרטים נוספים (לא חובה)" htmlFor="note">
        <textarea id="note" name="note" rows={3} className={inputCls + " resize-none"} placeholder="ספרו לנו בקצרה על המקרה שלכם" />
      </Field>
      <button
        type="submit"
        disabled={submitting}
        className="md-btn w-full text-black font-black py-4 rounded-xl text-lg disabled:opacity-60 flex items-center justify-center gap-2"
        style={{
          background: `linear-gradient(135deg, ${ORANGE} 0%, ${ORANGE_SOFT} 100%)`,
          boxShadow: `0 16px 36px -10px ${ORANGE}b3`,
        }}
      >
        {submitting ? "שולח..." : <>שלחו לבדיקה <ArrowLeft className="size-5" /></>}
      </button>
      <p className="text-[11px] text-center text-white/50 flex items-center justify-center gap-1.5">
        <ShieldCheck className="size-3" />
        בלחיצה על השליחה אני מאשר/ת קבלת פנייה חוזרת.
      </p>
    </form>
  );
}

function Field({ label, htmlFor, children }: { label: string; htmlFor: string; children: ReactNode }) {
  return (
    <div>
      <label className="block text-[11px] mb-1.5 text-white/60 font-bold mr-1 tracking-wider uppercase" htmlFor={htmlFor}>
        {label}
      </label>
      {children}
    </div>
  );
}

/* -------------------------------- bottom cta ------------------------------ */
function BottomCTA() {
  return (
    <section className="bg-black text-white relative overflow-hidden">
      <div
        className="absolute inset-0 opacity-[0.05]"
        aria-hidden
        style={{
          backgroundImage:
            "linear-gradient(to right, white 1px, transparent 1px), linear-gradient(to bottom, white 1px, transparent 1px)",
          backgroundSize: "44px 44px",
        }}
      />
      <div
        className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[30rem] h-[30rem] rounded-full blur-[160px] opacity-20"
        style={{ background: ORANGE }}
        aria-hidden
      />
      <div className="max-w-4xl mx-auto px-6 md:px-10 py-16 md:py-24 text-center relative">
        <div className="inline-flex items-center gap-2 mb-6">
          <span className="h-px w-8 bg-white/30" />
          <span className="text-[10px] font-bold tracking-[0.35em] uppercase" style={{ color: ORANGE_SOFT }}>
            צעד אחד אחרון
          </span>
          <span className="h-px w-8 bg-white/30" />
        </div>
        <h2
          className="text-[2.2rem] sm:text-4xl md:text-5xl leading-[1.05] font-bold mb-5 tracking-tight"
          style={fontDisplay}
        >
          רוצים לבדוק את<br />
          <span style={{ color: ORANGE }}>סיכויי המימון שלכם?</span>
        </h2>
        <p className="text-white/70 mb-9 text-[15px] md:text-base max-w-xl mx-auto">
          השאירו פרטים עכשיו ונחזור אליכם בהקדם. ללא עלות, ללא התחייבות, עם
          ניסיון של מעל 15 שנים.
        </p>
        <div className="flex flex-col sm:flex-row gap-3 justify-center">
          <a
            href="#form"
            className="md-btn text-black px-8 py-4 rounded-xl text-lg font-black flex items-center justify-center gap-2"
            style={{
              background: `linear-gradient(135deg, ${ORANGE} 0%, ${ORANGE_SOFT} 100%)`,
              boxShadow: `0 18px 40px -12px ${ORANGE}cc`,
            }}
          >
            השאירו פרטים <ArrowLeft className="size-5" />
          </a>
          <a
            href={`tel:${PHONE_TEL}`}
            className="md-btn-ghost text-white px-8 py-4 rounded-xl text-lg font-bold border border-white/20 hover:bg-white/10 hover:border-white/50 flex items-center justify-center gap-2"
          >
            <Phone className="size-4" />
            {PHONE_DISPLAY}
          </a>
        </div>
      </div>
    </section>
  );
}

/* ---------------------------------- footer -------------------------------- */
function Footer() {
  return (
    <footer className="bg-black border-t border-white/10 text-white">
      <div className="max-w-7xl mx-auto px-6 md:px-10 py-12 md:py-14 grid md:grid-cols-4 gap-8">
        <div className="md:col-span-1">
          <img
            src={logoAsset.url}
            alt="מטאדוק"
            width={180}
            height={64}
            className="h-14 w-auto object-contain bg-white/95 rounded-xl p-2 mb-4 inline-block"
          />
          <p className="text-white/60 text-sm leading-relaxed max-w-[34ch]">
            פתרונות מימון יצירתיים לבעלי נכסים שהבנקים אמרו להם "לא".
          </p>
        </div>
        <div>
          <div className="text-[10px] font-bold tracking-[0.3em] uppercase text-white/40 mb-4">צרו קשר</div>
          <div className="space-y-3 text-[14px]">
            <a href={`tel:${PHONE_TEL}`} className="flex items-center gap-2 text-white/80 hover:text-white transition-colors">
              <Phone className="size-4" style={{ color: ORANGE }} /> {PHONE_DISPLAY}
            </a>
            <a href={`mailto:${EMAIL}`} className="flex items-center gap-2 text-white/80 hover:text-white transition-colors break-all">
              <Mail className="size-4 shrink-0" style={{ color: ORANGE }} /> {EMAIL}
            </a>
            <a href={WHATSAPP} target="_blank" rel="noopener noreferrer" className="flex items-center gap-2 text-white/80 hover:text-white transition-colors">
              <MessageCircle className="size-4" style={{ color: ORANGE }} /> WhatsApp
            </a>
          </div>
        </div>
        <div>
          <div className="text-[10px] font-bold tracking-[0.3em] uppercase text-white/40 mb-4">כתובת</div>
          <div className="flex items-start gap-2 text-[14px] text-white/70">
            <MapPin className="size-4 mt-0.5 shrink-0" style={{ color: ORANGE }} />
            <span>{ADDRESS}</span>
          </div>
        </div>
        <div>
          <div className="text-[10px] font-bold tracking-[0.3em] uppercase text-white/40 mb-4">שעות פעילות</div>
          <div className="text-[14px] text-white/70 space-y-1">
            <div>א׳–ה׳ · 09:00–18:00</div>
            <div>ו׳ · 09:00–13:00</div>
          </div>
        </div>
      </div>
      <div className="border-t border-white/10">
        <div className="max-w-7xl mx-auto px-6 md:px-10 py-5 text-[11px] text-white/40 flex flex-wrap gap-3 justify-between">
          <p>© {new Date().getFullYear()} מטאדוק. כל הזכויות שמורות.</p>
          <p>מתן ההלוואה בכפוף לאישור הגוף המממן.</p>
        </div>
      </div>
    </footer>
  );
}

/* ------------------------------ helper section ---------------------------- */
function SectionLabel({ num, eyebrow, dark = false }: { num: string; eyebrow: string; dark?: boolean }) {
  return (
    <div className="flex items-center gap-3 mb-4">
      <span
        className="text-[11px] font-black tabular-nums tracking-widest"
        style={{ color: ORANGE, ...fontDisplay }}
      >
        {num} /
      </span>
      <span
        className={`text-[10px] font-bold tracking-[0.35em] uppercase ${
          dark ? "text-white/60" : "text-neutral-500"
        }`}
      >
        {eyebrow}
      </span>
    </div>
  );
}

function SectionHeading({ children, className = "" }: { children: ReactNode; className?: string }) {
  return (
    <h2
      className={`text-[2.2rem] sm:text-4xl md:text-5xl leading-[1.05] font-bold tracking-tight text-neutral-900 ${className}`}
      style={fontDisplay}
    >
      {children}
    </h2>
  );
}

/* ----------------------------- floating widgets --------------------------- */
function FloatingWhatsApp() {
  return (
    <a
      href={WHATSAPP}
      target="_blank"
      rel="noopener noreferrer"
      aria-label="שלחו וואטסאפ"
      className="fixed bottom-24 md:bottom-6 left-4 md:left-6 size-14 rounded-full bg-[#25D366] shadow-[0_8px_24px_rgba(37,211,102,0.4)] grid place-items-center z-40 active:scale-90 hover:scale-105 transition"
    >
      <MessageCircle className="size-7 text-white" />
    </a>
  );
}

function FloatingEligibility() {
  return (
    <a
      href="#form"
      aria-label="בדיקת זכאות חינם"
      className="fixed bottom-44 md:bottom-24 left-4 md:left-6 z-40 inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-black font-black text-[13px] md:text-[14px] md-btn hover:scale-105 transition"
      style={{
        background: `linear-gradient(135deg, ${ORANGE} 0%, ${ORANGE_SOFT} 100%)`,
        boxShadow: `0 12px 28px -8px ${ORANGE}cc, 0 0 0 3px rgba(255,122,0,0.18)`,
        fontFamily: "'Barlev', 'Atlas', system-ui, sans-serif",
      }}
    >
      <span className="relative flex size-2">
        <span className="absolute inline-flex h-full w-full rounded-full bg-black/40 animate-ping" />
        <span className="relative inline-flex rounded-full size-2 bg-black" />
      </span>
      בדיקת זכאות
      <ArrowLeft className="size-3.5" />
    </a>
  );
}

function StickyBottomBar() {
  return (
    <div className="md:hidden fixed bottom-0 inset-x-0 bg-black/95 backdrop-blur-lg border-t border-white/10 p-3 flex gap-3 z-50">
      <a
        href="#form"
        className="flex-1 text-black flex items-center justify-center gap-2 py-3 rounded-xl font-black text-sm"
        style={{
          background: `linear-gradient(135deg, ${ORANGE} 0%, ${ORANGE_SOFT} 100%)`,
          boxShadow: `0 8px 20px -8px ${ORANGE}b3`,
        }}
      >
        השאירו פרטים <ArrowLeft className="size-4" />
      </a>
      <a
        href={`tel:${PHONE_TEL}`}
        aria-label="חייגו"
        className="size-12 bg-white text-black rounded-xl grid place-items-center active:scale-95 transition"
      >
        <Phone className="size-5" />
      </a>
    </div>
  );
}
