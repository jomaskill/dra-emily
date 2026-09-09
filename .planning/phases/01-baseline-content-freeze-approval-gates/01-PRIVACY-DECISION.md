# LGPD, Consent, and Production Analytics Decision

This record separates configuration observed in the frozen repository from actual production collection and accountable LGPD approval. The configured GA4 identifier and rendered tag are observations only; they are not consent, lawful basis, collection proof, or release permission.

Production request, cookie, storage, consent, deny, and revoke behavior remains `not_measured` with an accountable owner and reason. The decision is pending. Validation is read-only and cannot inject scripts, enable analytics, change storage or network behavior, or modify consent.

Only opaque controlled-system locators belong here. Never store patient identifiers, WhatsApp message content, health data, credentials, or legal correspondence in this repository.

<!-- governance-privacy:start -->
{
  "schema_version": 1,
  "inventory_revision": "55be224238cbe07e2a79f3234284242315c1daef",
  "controller": null,
  "processors": [
    "google-analytics-configured-unverified"
  ],
  "purposes": [],
  "data_parameters": [
    "configured-ga4-id",
    "production-parameters-not-measured"
  ],
  "lawful_bases": [],
  "consent_trigger": null,
  "deny_behavior": null,
  "revoke_behavior": null,
  "retention": null,
  "access_roles": [],
  "transfers": [],
  "production_configuration": {
    "ga4_id": "G-FHD94M3R1T",
    "configured_tag_present": true,
    "observed_collection": null,
    "observed_tags": [
      "gtag-config:G-FHD94M3R1T",
      "script:https://www.googletagmanager.com/gtag/js?id=G-FHD94M3R1T"
    ],
    "consent_state": "not_measured",
    "measurement_status": "not_measured",
    "measurement_owner": "Named privacy owner required",
    "not_measured_reason": "Production analytics requests, cookies, local/session storage, consent behavior, and tag-manager configuration were not measured in the frozen run.",
    "source_revision": "55be224238cbe07e2a79f3234284242315c1daef"
  },
  "production_configuration_hash": "539c7c626b53dfcc41d6ce4ecb99f82c9019b31cf9aba52a388b8e74d0b633d9",
  "approver": null,
  "decided_on": null,
  "decision": "pending",
  "unresolved_questions": [
    "Confirm the controller and every processor/subprocessor.",
    "Confirm the precise purposes, data and parameters, lawful basis, consent trigger, deny and revoke behavior.",
    "Measure the exact production tag, request, cookie, local-storage, session-storage, and consent state.",
    "Approve retention, access roles, transfers, evidence references, applicability, and recheck date."
  ],
  "evidence_references": [
    "baseline:baseline-2026-09-09-local-herd-55be224"
  ],
  "applicable_revision": "55be224238cbe07e2a79f3234284242315c1daef",
  "recheck_on": null
}
<!-- governance-privacy:end -->

