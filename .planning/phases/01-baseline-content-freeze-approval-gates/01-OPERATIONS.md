# Clinic Operations Verification Register

Configured publication values and real-world observations are deliberately separate. These pending records do not prove the clinic's current identity, address, contact availability, opening hours, directions, accessibility, WhatsApp handling, escalation/response practice, or follow-up practice.

A named clinic operations verifier must add the observed value, verification date, opaque evidence locator, decision status, and recheck date. Missing, blank, stale, mismatched, duplicated, or conflicting evidence blocks release. Never copy a configured value into the observed field without direct verification.

<!-- governance-operations:start -->
{
  "schema_version": 1,
  "inventory_revision": "55be224238cbe07e2a79f3234284242315c1daef",
  "records": [
    {
      "stable_id": "operations.identity",
      "domain": "identity",
      "configured_value": "{\"name\":\"Dra. Emily Beatriz\",\"cro\":\"MG-069427\"}",
      "configured_source": "config/clinic.php and frozen public inventory",
      "observed_value": null,
      "verifier": null,
      "verified_on": null,
      "evidence_reference": null,
      "status": "pending",
      "recheck_on": null,
      "contexts": [
        {
          "route": "/",
          "context": "identity:source:1",
          "source": "resources/views/partials/footer.blade.php"
        },
        {
          "route": "/",
          "context": "identity:source:2",
          "source": "resources/views/partials/schema.blade.php"
        }
      ],
      "mismatch_notes": "No current real-world observation supplied. Configured publication is an assertion only."
    },
    {
      "stable_id": "operations.address",
      "domain": "address",
      "configured_value": "{\"street\":\"R. Conselheiro Galvão, 64\",\"neighborhood\":\"Santa Rosa\",\"city\":\"Belo Horizonte\",\"state\":\"MG\",\"zip\":\"31255-750\"}",
      "configured_source": "config/clinic.php and frozen public inventory",
      "observed_value": null,
      "verifier": null,
      "verified_on": null,
      "evidence_reference": null,
      "status": "pending",
      "recheck_on": null,
      "contexts": [
        {
          "route": "/",
          "context": "address:source:1",
          "source": "resources/views/partials/footer.blade.php"
        },
        {
          "route": "/",
          "context": "address:source:2",
          "source": "resources/views/partials/schema.blade.php"
        }
      ],
      "mismatch_notes": "No current real-world observation supplied. Configured publication is an assertion only."
    },
    {
      "stable_id": "operations.contact",
      "domain": "contact",
      "configured_value": "{\"whatsapp\":\"5531988480396\",\"instagram\":\"draemily.beatriz\"}",
      "configured_source": "config/clinic.php and frozen public inventory",
      "observed_value": null,
      "verifier": null,
      "verified_on": null,
      "evidence_reference": null,
      "status": "pending",
      "recheck_on": null,
      "contexts": [
        {
          "route": "/",
          "context": "contact:source:1",
          "source": "resources/views/partials/footer.blade.php"
        },
        {
          "route": "/",
          "context": "contact:source:2",
          "source": "resources/views/components/site-layout.blade.php"
        }
      ],
      "mismatch_notes": "No current real-world observation supplied. Configured publication is an assertion only."
    },
    {
      "stable_id": "operations.hours",
      "domain": "hours",
      "configured_value": "{\"weekdays\":[\"Monday\",\"Tuesday\",\"Wednesday\",\"Thursday\",\"Friday\"],\"opens\":\"09:00\",\"closes\":\"18:00\"}",
      "configured_source": "config/clinic.php and frozen public inventory",
      "observed_value": null,
      "verifier": null,
      "verified_on": null,
      "evidence_reference": null,
      "status": "pending",
      "recheck_on": null,
      "contexts": [
        {
          "route": "/",
          "context": "hours:source:1",
          "source": "resources/views/partials/schema.blade.php"
        }
      ],
      "mismatch_notes": "No current real-world observation supplied. Configured publication is an assertion only."
    },
    {
      "stable_id": "operations.directions",
      "domain": "directions",
      "configured_value": "{\"google_business_url\":\"https://maps.app.goo.gl/q4FE8CcJ1L3J9Bc77\"}",
      "configured_source": "config/clinic.php and frozen public inventory",
      "observed_value": null,
      "verifier": null,
      "verified_on": null,
      "evidence_reference": null,
      "status": "pending",
      "recheck_on": null,
      "contexts": [
        {
          "route": "/",
          "context": "directions:source:1",
          "source": "resources/views/partials/schema.blade.php"
        }
      ],
      "mismatch_notes": "No current real-world observation supplied. Configured publication is an assertion only."
    },
    {
      "stable_id": "operations.accessibility",
      "domain": "accessibility",
      "configured_value": "{\"configured_public_value\":null}",
      "configured_source": "config/clinic.php and frozen public inventory",
      "observed_value": null,
      "verifier": null,
      "verified_on": null,
      "evidence_reference": null,
      "status": "pending",
      "recheck_on": null,
      "contexts": [
        {
          "route": "/",
          "context": "accessibility:source:1",
          "source": "resources/views/partials/footer.blade.php"
        }
      ],
      "mismatch_notes": "No current real-world observation supplied. Configured publication is an assertion only."
    },
    {
      "stable_id": "operations.whatsapp_operations",
      "domain": "whatsapp_operations",
      "configured_value": "{\"number\":\"5531988480396\",\"prefill\":\"Olá! Gostaria de agendar uma consulta com a Dra. Emily.\"}",
      "configured_source": "config/clinic.php and frozen public inventory",
      "observed_value": null,
      "verifier": null,
      "verified_on": null,
      "evidence_reference": null,
      "status": "pending",
      "recheck_on": null,
      "contexts": [
        {
          "route": "/",
          "context": "whatsapp_operations:source:1",
          "source": "resources/views/components/site-layout.blade.php"
        }
      ],
      "mismatch_notes": "No current real-world observation supplied. Configured publication is an assertion only."
    },
    {
      "stable_id": "operations.escalation_response",
      "domain": "escalation_response",
      "configured_value": "{\"configured_public_value\":null}",
      "configured_source": "config/clinic.php and frozen public inventory",
      "observed_value": null,
      "verifier": null,
      "verified_on": null,
      "evidence_reference": null,
      "status": "pending",
      "recheck_on": null,
      "contexts": [
        {
          "route": "/",
          "context": "escalation_response:source:1",
          "source": "resources/views/welcome.blade.php"
        }
      ],
      "mismatch_notes": "No current real-world observation supplied. Configured publication is an assertion only."
    },
    {
      "stable_id": "operations.follow_up",
      "domain": "follow_up",
      "configured_value": "{\"configured_public_value\":null}",
      "configured_source": "config/clinic.php and frozen public inventory",
      "observed_value": null,
      "verifier": null,
      "verified_on": null,
      "evidence_reference": null,
      "status": "pending",
      "recheck_on": null,
      "contexts": [
        {
          "route": "/",
          "context": "follow_up:source:1",
          "source": "resources/views/welcome.blade.php"
        }
      ],
      "mismatch_notes": "No current real-world observation supplied. Configured publication is an assertion only."
    }
  ]
}
<!-- governance-operations:end -->

