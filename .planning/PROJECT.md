# Dra. Emily Beatriz — Website Conversion Review

## What This Is

A patient-acquisition website for Dra. Emily Beatriz, a cirurgiã-dentista in Belo Horizonte who provides facial harmonization and related aesthetic procedures. This milestone reviews and improves the website as a complete conversion journey, helping cautious prospective patients understand their options, trust the professional and the treatment process, and begin a personalized consultation through WhatsApp.

## Core Value

Turn qualified local visitors into WhatsApp consultation conversations by making the website credible, reassuring, clinically responsible, and easy to act on.

## Business Context

- **Customer**: Adults in Belo Horizonte considering subtle, personalized facial aesthetic treatment, including first-time or safety-conscious patients
- **Revenue model**: Consultations that lead to eligible, professionally indicated procedures
- **Success metric**: Measurable WhatsApp consultation starts attributable to a website page and call to action
- **Strategy notes**: Begin with evidence-based broad positioning; use traffic and conversion data to determine which audiences and procedures deserve greater prominence

## Requirements

### Validated

- ✓ Visitors can discover Dra. Emily, her philosophy, clinic location, and contact details on a responsive public landing page — existing
- ✓ Visitors can explore dedicated pages for Botox, preenchimento labial, harmonização facial, Full Face, and bioestimulador de colágeno — existing
- ✓ Visitors can begin a procedure-aware WhatsApp conversation from the homepage and procedure pages — existing
- ✓ Visitors can review testimonials, before-and-after content, treatment explanations, benefits, steps, and frequently asked questions — existing
- ✓ Search engines receive canonical metadata, structured data, and an XML sitemap generated from the same clinic and procedure configuration — existing
- ✓ The site has a GA4 measurement identifier and a Google Business profile link available through centralized configuration — existing

### Active

- [ ] Audit the complete mobile and desktop journey for conversion clarity, information hierarchy, usability, visual trust, accessibility, performance, and technical quality
- [ ] Reframe positioning around natural results, individualized assessment, patient concerns, safety, professional qualifications, realistic expectations, and follow-up
- [ ] Review all clinical and promotional copy for accuracy, substantiation, non-guaranteed outcomes, and consistency across visible pages and structured data
- [ ] Review professional identification, specialty claims, testimonials, patient imagery, consent expectations, and other advertising elements against current CRO/CFO requirements and the August 2026 legal uncertainty around HOF regulation
- [ ] Make the WhatsApp consultation the primary conversion while preserving useful procedure discovery and local contact information
- [ ] Instrument named conversion events that identify the source page, procedure, and CTA placement for each WhatsApp click
- [ ] Improve local search trust with accurate clinic information, demonstrable professional expertise, clinically reviewed content, and validated structured data
- [ ] Establish an evidence-based baseline and use observed traffic and conversion data before narrowing the audience or declaring a flagship procedure
- [ ] Protect the existing configuration-driven Laravel architecture and cover critical public journeys with automated tests

### Out of Scope

- Online appointment scheduling — WhatsApp consultation remains the primary conversion for this milestone
- A CRM, patient portal, authentication flow, or clinical-record system — the website remains a public acquisition experience
- Selecting a flagship procedure without traffic, lead-quality, or commercial evidence — prominence will follow measurement
- Guaranteed clinical outcomes, universal candidacy, or absolute safety claims — outcomes and indications are individualized
- Advertising prices, discounts, promotions, or payment offers — excluded pending explicit business need and compliance review
- A wholesale rebrand or framework replacement — changes should improve the current brand and Laravel/Blade implementation unless the audit demonstrates a specific need

## Context

The site is a Laravel 13 application with server-rendered Blade templates, Tailwind CSS, and configuration-backed clinic, procedure, and FAQ content. It currently includes a homepage, reusable procedure template, a specialized Full Face page, responsive images, WhatsApp CTAs, testimonials, before-and-after imagery, SEO metadata, structured data, and an XML sitemap.

Traffic is currently too limited to support a reliable audience or procedure-priority conclusion. Research therefore establishes an initial hypothesis: adults in Belo Horizonte who want subtle facial improvement but may hesitate because of artificial-looking results, safety, pain, cost, recovery, or uncertainty about which treatment is appropriate. The site should sell a trustworthy personalized assessment rather than a fixed treatment package.

Research indicates that common motivations include looking rested or slightly younger, delaying visible aging, addressing a specific facial concern, and improving confidence while preserving identity. Major barriers include safety concerns, fear of needles or discomfort, cost uncertainty, and unnatural-looking outcomes. Content and conversion design should address those barriers directly without exploiting insecurity.

The current copy includes statements that may read as guarantees or overconfident clinical claims. Clinical facts, durations, candidacy, aftercare instructions, comparative claims, and outcome language require professional review. Patient imagery and testimonials require confirmation of provenance, written authorization, responsible-professional attribution, and applicability of CFO advertising rules to this personally branded website.

As of August 2026, a federal appellate decision concerning CFO Resolution 198/2019 created legal uncertainty around the recognition and scope of Harmonização Orofacial as an odontological specialty. The CFO states that it is challenging the decision and that professional duties have not immediately changed. The website must not infer or advertise a specialty title beyond Dra. Emily's current CRO registration, and scope-sensitive claims require current CRO-MG or qualified legal review before publication.

## Constraints

- **Professional scope**: Dra. Emily is identified through CRO-MG; advertising and professional-title decisions must follow current odontological rules and verified registrations
- **Clinical accuracy**: Treatment claims, benefits, risks, duration, recovery, and candidacy require review by the treating professional before release
- **Patient privacy**: Patient images and testimonials require documented authorization and compliant publication context
- **Evidence**: Low traffic means audience and procedure prioritization remain hypotheses until measurement produces sufficient data
- **Conversion**: WhatsApp consultation is the primary conversion; attribution must not collect sensitive health information in analytics
- **Architecture**: Preserve Laravel 13, Blade, Tailwind CSS, centralized configuration, named routes, and reusable components
- **Language and locality**: Patient-facing copy remains Brazilian Portuguese and targets Belo Horizonte without excluding relevant nearby patients
- **Accessibility and performance**: Improvements must work on mobile-first public pages and avoid unnecessary JavaScript or heavy assets

## Key Decisions

| Decision | Rationale | Outcome |
|----------|-----------|---------|
| Research facial harmonization before defining the review | The website has too little traffic to justify audience and procedure assumptions | — Pending |
| Optimize for WhatsApp consultation rather than immediate procedure purchase | Facial harmonization requires individualized assessment, expectation setting, and suitability screening | — Pending |
| Start with broad local, natural-results positioning | Evidence supports naturalness and safety as major decision factors, while current traffic cannot sustain narrower segmentation | — Pending |
| Treat professional credibility and safety as conversion features | Patient barriers center on qualifications, complications, discomfort, and artificial outcomes | — Pending |
| Measure before naming a flagship procedure | Current content prominence is not backed by traffic, lead quality, or revenue evidence | — Pending |
| Escalate specialty and scope-sensitive claims for current compliance review | The August 2026 legal situation creates material uncertainty that a website implementation cannot resolve | — Pending |
| Improve the existing application rather than assume a complete redesign | The site already has a coherent responsive architecture and conversion foundation | — Pending |

## Evolution

This document evolves at phase transitions and milestone boundaries.

**After each phase transition** (via `/gsd-transition`):
1. Requirements invalidated? → Move to Out of Scope with reason
2. Requirements validated? → Move to Validated with phase reference
3. New requirements emerged? → Add to Active
4. Decisions to log? → Add to Key Decisions
5. "What This Is" still accurate? → Update if drifted

**After each milestone** (via `/gsd:complete-milestone`):
1. Full review of all sections
2. Core Value check — still the right priority?
3. Audit Out of Scope — reasons still valid?
4. Update Context with current state

---
*Last updated: 2026-09-08 after initialization*
