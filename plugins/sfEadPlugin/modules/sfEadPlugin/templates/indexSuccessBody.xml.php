<ead>
<eadheader langencoding="iso639-2b" countryencoding="iso3166-1" dateencoding="iso8601" repositoryencoding="iso15511" scriptencoding="iso15924" relatedencoding="DC">
  <?php echo $ead->renderEadId() ?>
  <filedesc>
    <titlestmt>
      <?php if (0 < strlen($value = $resource->getTitle(array('cultureFallback' => true)))): ?>
        <titleproper encodinganalog="<?php echo $ead->getMetadataParameter('titleproper') ?>"><?php echo escape_dc(esc_specialchars($value)) ?></titleproper>
      <?php endif; ?>
    </titlestmt>
    <?php
      // TODO: find out if we need this element as it's not imported by our EAD importer
      if (0 < strlen($value = $resource->getEdition(array('cultureFallback' => true)))): ?>
      <editionstmt>
        <edition><?php echo escape_dc(esc_specialchars($value)) ?></edition>
      </editionstmt>
    <?php endif; ?>
    <?php if ($value = $resource->getRepository(array('inherit' => true))): ?>
      <publicationstmt>
        <publisher encodinganalog="<?php echo $ead->getMetadataParameter('publisher') ?>"><?php echo escape_dc(esc_specialchars($value->__toString())) ?></publisher>
        <?php if ($address = $value->getPrimaryContact()): ?>
          <address>
            <?php if (0 < strlen($addressline = $address->getStreetAddress())): ?>
              <addressline><?php echo escape_dc(esc_specialchars($addressline)) ?></addressline>
            <?php endif; ?>
            <?php if (0 < strlen($addressline = $address->getCity())): ?>
              <addressline><?php echo escape_dc(esc_specialchars($addressline)) ?></addressline>
            <?php endif; ?>
            <?php if (0 < strlen($addressline = $address->getRegion())): ?>
              <addressline><?php echo escape_dc(esc_specialchars($addressline)) ?></addressline>
            <?php endif; ?>
            <?php if (0 < strlen($addressline = $resource->getRepositoryCountry())): ?>
              <addressline><?php echo escape_dc(esc_specialchars($addressline)) ?></addressline>
            <?php endif; ?>
            <?php if (0 < strlen($addressline = $address->getPostalCode())): ?>
              <addressline><?php echo escape_dc(esc_specialchars($addressline)) ?></addressline>
            <?php endif; ?>
            <?php if (0 < strlen($addressline = $address->getTelephone())): ?>
              <addressline><?php echo __('Telephone: ').escape_dc(esc_specialchars($addressline)) ?></addressline>
            <?php endif; ?>
            <?php if (0 < strlen($addressline = $address->getFax())): ?>
              <addressline><?php echo __('Fax: ').escape_dc(esc_specialchars($addressline)) ?></addressline>
            <?php endif; ?>
            <?php if (0 < strlen($addressline = $address->getEmail())): ?>
              <addressline><?php echo __('Email: ').escape_dc(esc_specialchars($addressline)) ?></addressline>
            <?php endif; ?>
            <?php if (0 < strlen($addressline = $address->getWebsite())): ?>
              <addressline><?php echo escape_dc(esc_specialchars($addressline)) ?></addressline>
            <?php endif; ?>
          </address>
        <?php endif; ?>
        <date normal="<?php echo $ead->getPublicationDate() ?>" encodinganalog="<?php echo $ead->getMetadataParameter('date') ?>"><?php echo escape_dc(esc_specialchars($ead->getPublicationDate())) ?></date>
      </publicationstmt>
    <?php endif; ?>
  </filedesc>
  <profiledesc>
    <creation>
      <?php echo __('Generated by %1%', array('%1%' => $ead->version)) ?>
      <date normal="<?php echo gmdate('o-m-d') ?>"><?php echo gmdate('o-m-d H:i e') ?></date>
    </creation>
    <langusage>
      <language langcode="<?php echo strtolower($iso639convertor->getID2($exportLanguage)) ?>"><?php echo format_language($exportLanguage) ?></language>
      <?php if (0 < strlen($languageOfDescription = $resource->getPropertyByName('languageOfDescription')->__toString())): ?>
        <?php $langsOfDesc = unserialize($languageOfDescription); ?>
        <?php if (is_array($langsOfDesc)): ?>
          <?php foreach($langsOfDesc as $langcode): ?>
            <?php if ($langcode != $exportLanguage): ?>
              <language langcode="<?php echo strtolower($iso639convertor->getID2($langcode))?>"><?php echo format_language($langcode) ?></language>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      <?php endif; ?>
      <?php foreach ($resource->scriptOfDescription as $code): ?>
        <language scriptcode="<?php echo $code ?>"><?php echo format_script($code) ?></language>
      <?php endforeach; ?>
    </langusage>
    <?php if (0 < strlen($rules = $resource->getRules(array('cultureFallback' => true)))): ?>
      <descrules <?php if (0 < strlen($encoding = $ead->getMetadataParameter('descrules'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?>><?php echo escape_dc(esc_specialchars($rules)) ?></descrules>
    <?php endif; ?>
  </profiledesc>
</eadheader>

<archdesc <?php echo $ead->renderLOD($resource, $eadLevels) ?> relatedencoding="<?php echo $ead->getMetadataParameter('relatedencoding') ?>">
  <?php

  $resourceVar = 'resource';
  $counter = 0;
  $counterVar = 'counter';

  $creators = $$resourceVar->getCreators();
  $events = $$resourceVar->getActorEvents(array('eventTypeId' => QubitTerm::CREATION_ID));

  $topLevelDid = true;

  include('indexSuccessBodyDidElement.xml.php');
  include('indexSuccessBodyBioghistElement.xml.php');

  $topLevelDid = false;
  ?>

  <?php if ($resource->getPublicationStatus()): ?>
    <odd type="publicationStatus"><p><?php echo escape_dc(esc_specialchars($resource->getPublicationStatus())) ?></p></odd>
  <?php endif; ?>
  <?php if ($resource->descriptionDetailId): ?>
    <odd type="levelOfDetail"><p><?php echo escape_dc(esc_specialchars((string)QubitTerm::getById($resource->descriptionDetailId))) ?></p></odd>
  <?php endif; ?>
  <?php $descriptionStatus = ($resource->descriptionStatusId) ? QubitTerm::getById($resource->descriptionStatusId) : ''; ?>
  <?php if ($descriptionStatus): ?>
    <odd type="statusDescription"><p><?php echo escape_dc(esc_specialchars((string)$descriptionStatus)) ?></p></odd>
  <?php endif; ?>
  <?php if ($resource->descriptionIdentifier): ?>
    <odd type="descriptionIdentifier"><p><?php echo escape_dc(esc_specialchars($resource->descriptionIdentifier)) ?></p></odd>
  <?php endif; ?>
  <?php if ($resource->institutionResponsibleIdentifier): ?>
    <odd type="institutionIdentifier"><p><?php echo escape_dc(esc_specialchars($resource->institutionResponsibleIdentifier)) ?></p></odd>
  <?php endif; ?>

  <?php
  // Load taxonomies into variables to avoid use of magic numbers
  $termData = QubitFlatfileImport::loadTermsFromTaxonomies(array(
    QubitTaxonomy::RAD_NOTE_ID       => 'radNoteTypes',
    QubitTaxonomy::RAD_TITLE_NOTE_ID => 'titleNoteTypes',
    QubitTaxonomy::DACS_NOTE_ID      => 'dacsSpecializedNoteTypes'
  ));

  $radTitleNotes = array(
    'Variations in title'                         => 'titleVariation',
    'Attributions and conjectures'                => 'titleAttributions',
    'Continuation of title'                       => 'titleContinuation',
    'Statements of responsibility'                => 'titleStatRep',
    'Parallel titles and other title information' => 'titleParallel',
    'Source of title proper'                      => 'titleSource'
  );

  foreach ($radTitleNotes as $name => $xmlType)
  {
    $noteTypeId = array_search($name, $termData['titleNoteTypes']['en']);

    if (0 < count($notes = $resource->getNotesByType(array('noteTypeId' => $noteTypeId)))):
      foreach ($notes as $note): ?>
        <odd type="<?php echo $xmlType ?>" <?php if (0 < strlen($encoding = $ead->getMetadataParameter($xmlType))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?>><p><?php echo escape_dc(esc_specialchars($note->getContent(array('cultureFallback' => true)))) ?></p></odd>
      <?php endforeach;
    endif;
  }

  $radNotes = array(
    'Edition'                    => 'edition',
    'Physical description'       => 'physDesc',
    'Conservation'               => 'conservation',
    'Accompanying material'      => 'material',
    'Alpha-numeric designations' => 'alphanumericDesignation',
    "Publisher's series"         => 'bibSeries',
    'Rights'                     => 'rights'
  );

  foreach($radNotes as $name => $xmlType)
  {
    $noteTypeId = array_search($name, $termData['radNoteTypes']['en']);

    if (0 < count($notes = $resource->getNotesByType(array('noteTypeId' => $noteTypeId)))):
      foreach ($notes as $note): ?>
        <odd type="<?php echo $xmlType ?>" <?php if (0 < strlen($encoding = $ead->getMetadataParameter($xmlType))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?>><p><?php echo escape_dc(esc_specialchars($note->getContent(array('cultureFallback' => true)))) ?></p></odd>
      <?php endforeach;
    endif;
  }

  $dacsSpecializedNotes = array(
    'Conservation'              => 'dacsConservation',
    'Citation'                  => 'dacsCitation',
    'Alphanumeric designations' => 'dacsAlphanumericDesignation',
    'Variant title information' => 'dacsVariantTitleInformation',
    'Processing information'    => 'dacsProcessingInformation'
  );

  foreach ($dacsSpecializedNotes as $name => $xmlType)
  {
    $noteTypeId = array_search($name, $termData['dacsSpecializedNoteTypes']['en']);

    if (0 < count($notes = $resource->getNotesByType(array('noteTypeId' => $noteTypeId)))):
      foreach ($notes as $note): ?>
        <odd type="<?php echo $xmlType ?>" <?php if (0 < strlen($encoding = $ead->getMetadataParameter($xmlType))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?>><p><?php echo escape_dc(esc_specialchars($note->getContent(array('cultureFallback' => true)))) ?></p></odd>
      <?php endforeach;
    endif;
  } ?>

  <?php if (0 < strlen($value = $resource->getPropertyByName('noteOnPublishersSeries')->__toString())): ?>
    <odd type='bibSeries'><p><?php echo escape_dc(esc_specialchars($value)) ?></p></odd>
  <?php endif; ?>
  <?php if (0 < strlen($value = $resource->getScopeAndContent(array('cultureFallback' => true)))): ?>
    <scopecontent encodinganalog="<?php echo $ead->getMetadataParameter('scopecontent') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></scopecontent><?php endif; ?>
  <?php if (0 < strlen($value = $resource->getArrangement(array('cultureFallback' => true)))): ?>
    <arrangement encodinganalog="<?php echo $ead->getMetadataParameter('arrangement') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></arrangement><?php endif; ?>

  <?php if ($ead->getControlAccessFields($resource, $materialTypes, $genres, $subjects, $names, $places, $placeEvents)): ?>
    <controlaccess>
      <?php foreach ($resource->getActorEvents() as $event): ?>
        <?php if ($event->getType()->getRole() != 'Creator'): ?>

        <?php if ($event->getActor()->getEntityTypeId() == QubitTerm::PERSON_ID): ?>
          <persname role="<?php echo $event->getType()->getRole() ?>" <?php if (0 < strlen($encoding = $ead->getMetadataParameter('name'.$event->getType()->getRole()))): ?>encodinganalog="<?php echo $encoding ?>"<?php elseif (0 < strlen($encoding = $ead->getMetadataParameter('nameDefault'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?> id="atom_<?php echo $event->id ?>_actor"><?php echo escape_dc(esc_specialchars(render_title($event->getActor()))) ?></persname>
        <?php elseif ($event->getActor()->getEntityTypeId() == QubitTerm::FAMILY_ID): ?>
          <famname role="<?php echo $event->getType()->getRole() ?>" <?php if (0 < strlen($encoding = $ead->getMetadataParameter('name'.$event->getType()->getRole()))): ?>encodinganalog="<?php echo $encoding ?>"<?php elseif (0 < strlen($encoding = $ead->getMetadataParameter('nameDefault'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?> id="atom_<?php echo $event->id ?>_actor"><?php echo escape_dc(esc_specialchars(render_title($event->getActor()))) ?></famname>
        <?php elseif ($event->getActor()->getEntityTypeId() == QubitTerm::CORPORATE_BODY_ID): ?>
          <corpname role="<?php echo $event->getType()->getRole() ?>" <?php if (0 < strlen($encoding = $ead->getMetadataParameter('name'.$event->getType()->getRole()))): ?>encodinganalog="<?php echo $encoding ?>"<?php elseif (0 < strlen($encoding = $ead->getMetadataParameter('nameDefault'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?> id="atom_<?php echo $event->id ?>_actor"><?php echo escape_dc(esc_specialchars(render_title($event->getActor()))) ?></corpname>
        <?php else: ?>
          <name role="<?php echo $event->getType()->getRole() ?>" <?php if (0 < strlen($encoding = $ead->getMetadataParameter('name'.$event->getType()->getRole()))): ?>encodinganalog="<?php echo $encoding ?>"<?php elseif (0 < strlen($encoding = $ead->getMetadataParameter('nameDefault'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?> id="atom_<?php echo $event->id ?>_actor"><?php echo escape_dc(esc_specialchars(render_title($event->getActor()))) ?></name>
        <?php endif; ?>

        <?php endif; ?>
      <?php endforeach; ?>
      <?php foreach ($names as $name): ?>
        <?php if (get_class($name->getObject()) === 'QubitTerm'): ?>
          <name role="subject"><?php echo escape_dc(esc_specialchars((string)$name->getObject())) ?></name>
        <?php else: ?>
          <?php if ($name->getObject()->getEntityTypeId() == QubitTerm::PERSON_ID): ?>
            <persname role="subject"><?php echo escape_dc(esc_specialchars((string)$name->getObject())) ?></persname>
          <?php elseif ($name->getObject()->getEntityTypeId() == QubitTerm::FAMILY_ID): ?>
            <famname role="subject"><?php echo escape_dc(esc_specialchars((string)$name->getObject())) ?></famname>
          <?php elseif ($name->getObject()->getEntityTypeId() == QubitTerm::CORPORATE_BODY_ID): ?>
            <corpname role="subject"><?php echo escape_dc(esc_specialchars((string)$name->getObject())) ?></corpname>
          <?php else: ?>
            <name role="subject"><?php echo escape_dc(esc_specialchars((string)$name->getObject())) ?></name>
          <?php endif; ?>
        <?php endif; ?>
      <?php endforeach; ?>
      <?php foreach ($materialTypes as $materialtype): ?>
        <genreform source="rad" <?php if (0 < strlen($encoding = $ead->getMetadataParameter('materialType'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?>><?php echo escape_dc(escape_dc(esc_specialchars((string)$materialtype->getTerm()))) ?></genreform>
      <?php endforeach; ?>
      <?php foreach ($genres as $genre): ?>
        <genreform><?php echo escape_dc(esc_specialchars((string)$genre->getTerm())) ?></genreform>
      <?php endforeach; ?>
      <?php foreach ($subjects as $subject): ?>
        <subject<?php if ($subject->getTerm()->code):?> authfilenumber="<?php echo $subject->getTerm()->code ?>"<?php endif; ?>><?php echo escape_dc(esc_specialchars((string)$subject->getTerm())) ?></subject>
      <?php endforeach; ?>
      <?php foreach ($places as $place): ?>
        <geogname><?php echo escape_dc(esc_specialchars((string)$place->getTerm())) ?></geogname>
      <?php endforeach; ?>
      <?php foreach ($placeEvents as $place): ?>
        <geogname role="<?php echo $place->getObject()->getType()->getRole() ?>" <?php if (0 < strlen($encoding = $ead->getMetadataParameter('geog'.$place->getObject()->getType()->getRole()))): ?>encodinganalog="<?php echo $encoding ?>"<?php elseif (0 < strlen($encoding = $ead->getMetadataParameter('geogDefault'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?> id="atom_<?php echo $place->objectId ?>_place"><?php echo escape_dc(esc_specialchars((string)$place->getTerm())) ?></geogname>
      <?php endforeach; ?>
    </controlaccess>
  <?php endif; ?>
  <?php if (0 < strlen($value = $resource->getPhysicalCharacteristics(array('cultureFallback' => true)))): ?>
    <phystech encodinganalog="<?php echo $ead->getMetadataParameter('phystech') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></phystech>
  <?php endif; ?>
  <?php if (0 < strlen($value = $resource->getAppraisal(array('cultureFallback' => true)))): ?>
    <appraisal <?php if (0 < strlen($encoding = $ead->getMetadataParameter('appraisal'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?>><p><?php echo escape_dc(esc_specialchars($value)) ?></p></appraisal>
  <?php endif; ?>
  <?php if (0 < strlen($value = $resource->getAcquisition(array('cultureFallback' => true)))): ?>
    <acqinfo encodinganalog="<?php echo $ead->getMetadataParameter('acqinfo') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></acqinfo>
  <?php endif; ?>
  <?php if (0 < strlen($value = $resource->getAccruals(array('cultureFallback' => true)))): ?>
    <accruals encodinganalog="<?php echo $ead->getMetadataParameter('accruals') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></accruals>
  <?php endif; ?>
  <?php if (0 < strlen($value = $resource->getArchivalHistory(array('cultureFallback' => true)))): ?>
    <custodhist encodinganalog="<?php echo $ead->getMetadataParameter('custodhist') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></custodhist>
  <?php endif; ?>

  <?php $archivistsNotes = $resource->getNotesByType(array('noteTypeId' => QubitTerm::ARCHIVIST_NOTE_ID)) ?>
  <?php if (0 < strlen($value = $resource->getRevisionHistory(array('cultureFallback' => true))) || 0 < count($archivistsNotes)): ?>

    <processinfo>
      <?php if ($value): ?>
        <p><date><?php echo escape_dc(esc_specialchars($value)) ?></date></p>
      <?php endif; ?>

      <?php if (0 < count($archivistsNotes)): ?>
        <?php foreach ($archivistsNotes as $note): ?>
          <p><?php echo escape_dc(esc_specialchars($note->getContent(array('cultureFallback' => true)))) ?></p>
        <?php endforeach; ?>
      <?php endif; ?>
    </processinfo>
  <?php endif; ?>

  <?php if (0 < strlen($value = $resource->getLocationOfOriginals(array('cultureFallback' => true)))): ?>
    <originalsloc encodinganalog="<?php echo $ead->getMetadataParameter('originalsloc') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></originalsloc>
  <?php endif; ?>
  <?php if (0 < strlen($value = $resource->getLocationOfCopies(array('cultureFallback' => true)))): ?>
    <altformavail encodinganalog="<?php echo $ead->getMetadataParameter('altformavail') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></altformavail>
  <?php endif; ?>
  <?php if (0 < strlen($value = $resource->getRelatedUnitsOfDescription(array('cultureFallback' => true)))): ?>
    <relatedmaterial encodinganalog="<?php echo $ead->getMetadataParameter('relatedmaterial') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></relatedmaterial>
  <?php endif; ?>
  <?php if (0 < strlen($value = $resource->getAccessConditions(array('cultureFallback' => true)))): ?>
    <accessrestrict encodinganalog="<?php echo $ead->getMetadataParameter('accessrestrict') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></accessrestrict>
  <?php endif; ?>
  <?php if (0 < strlen($value = $resource->getReproductionConditions(array('cultureFallback' => true)))): ?>
    <userestrict encodinganalog="<?php echo $ead->getMetadataParameter('userestrict') ?>"><p><?php echo escape_dc(esc_specialchars($value))  ?></p></userestrict>
  <?php endif; ?>
  <?php if (0 < strlen($value = $resource->getFindingAids(array('cultureFallback' => true)))): ?>
    <otherfindaid encodinganalog="<?php echo $ead->getMetadataParameter('otherfindaid') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></otherfindaid>
  <?php endif; ?>
  <?php if (0 < count($publicationNotes = $resource->getNotesByType(array('noteTypeId' => QubitTerm::PUBLICATION_NOTE_ID)))): ?>
    <?php foreach ($publicationNotes as $note): ?>
      <bibliography <?php if (0 < strlen($encoding = $ead->getMetadataParameter('bibliography'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?>><p><?php echo escape_dc(esc_specialchars($note->getContent(array('cultureFallback' => true)))) ?></p></bibliography>
    <?php endforeach; ?>
  <?php endif; ?>

  <?php if (!array_key_exists('current-level-only', $options) || !$options['current-level-only']): ?>
  <dsc type="combined">

    <?php $nestedRgt = array() ?>
    <?php foreach ($resource->getDescendantsForExport($options) as $descendant): ?>

      <?php // Close previous <c> tags when we pass the end of the child list ?>
      <?php $rgt = $descendant->rgt ?>
      <?php while (count($nestedRgt) > 0 && $rgt > $nestedRgt[count($nestedRgt) - 1]): ?>
        <?php array_pop($nestedRgt); ?>
        </c>
      <?php endwhile; ?>

      <c <?php echo $ead->renderLOD($descendant, $eadLevels) ?>>

      <?php
        $resourceVar = 'descendant';
        $creators = $$resourceVar->getCreators();
        $events = $$resourceVar->getActorEvents(array('eventTypeId' => QubitTerm::CREATION_ID));

        include('indexSuccessBodyDidElement.xml.php');
        include('indexSuccessBodyBioghistElement.xml.php');
      ?>

      <?php if ($descendant->getPublicationStatus()): ?>
        <odd type="publicationStatus"><p><?php echo escape_dc(esc_specialchars($descendant->getPublicationStatus())) ?></p></odd>
      <?php endif; ?>

      <?php if (0 < strlen($value = $descendant->getScopeAndContent(array('cultureFallback' => true)))): ?>
        <scopecontent encodinganalog="<?php echo $ead->getMetadataParameter('scopecontent') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></scopecontent>
      <?php endif; ?>

      <?php if (0 < strlen($value = $descendant->getArrangement(array('cultureFallback' => true)))): ?>
        <arrangement encodinganalog="<?php echo $ead->getMetadataParameter('arrangement') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></arrangement>
      <?php endif; ?>

      <?php if ($ead->getControlAccessFields($descendant, $materialTypes, $genres, $subjects, $names, $places, $placeEvents)): ?>

        <controlaccess>

          <?php foreach ($descendant->getActorEvents() as $event): ?>
            <?php if ($event->getType()->getRole() != 'Creator'): ?>

              <?php if ($event->getActor()->getEntityTypeId() == QubitTerm::PERSON_ID): ?>
                <persname role="<?php echo $event->getType()->getRole() ?>" <?php if (0 < strlen($encoding = $ead->getMetadataParameter('name'.$event->getType()->getRole()))): ?>encodinganalog="<?php echo $encoding ?>"<?php elseif (0 < strlen($encoding = $ead->getMetadataParameter('nameDefault'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?> id="atom_<?php echo $event->id ?>_actor"><?php echo escape_dc(esc_specialchars(render_title($event->getActor(array('cultureFallback' => true))))) ?> </persname>
              <?php elseif ($event->getActor()->getEntityTypeId() == QubitTerm::FAMILY_ID): ?>
                <famname role="<?php echo $event->getType()->getRole() ?>" <?php if (0 < strlen($encoding = $ead->getMetadataParameter('name'.$event->getType()->getRole()))): ?>encodinganalog="<?php echo $encoding ?>"<?php elseif (0 < strlen($encoding = $ead->getMetadataParameter('nameDefault'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?> id="atom_<?php echo $event->id ?>_actor"><?php echo escape_dc(esc_specialchars(render_title($event->getActor(array('cultureFallback' => true))))) ?> </famname>
              <?php elseif ($event->getActor()->getEntityTypeId() == QubitTerm::CORPORATE_BODY_ID): ?>
                <corpname role="<?php echo $event->getType()->getRole() ?>" <?php if (0 < strlen($encoding = $ead->getMetadataParameter('name'.$event->getType()->getRole()))): ?>encodinganalog="<?php echo $encoding ?>"<?php elseif (0 < strlen($encoding = $ead->getMetadataParameter('nameDefault'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?> id="atom_<?php echo $event->id ?>_actor"><?php echo escape_dc(esc_specialchars(render_title($event->getActor(array('cultureFallback' => true))))) ?> </corpname>
              <?php else: ?>
                <name role="<?php echo $event->getType()->getRole() ?>" <?php if (0 < strlen($encoding = $ead->getMetadataParameter('name'.$event->getType()->getRole()))): ?>encodinganalog="<?php echo $encoding ?>"<?php elseif (0 < strlen($encoding = $ead->getMetadataParameter('nameDefault'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?> id="atom_<?php echo $event->id ?>_actor"><?php echo escape_dc(esc_specialchars(render_title($event->getActor(array('cultureFallback' => true))))) ?> </name>
              <?php endif; ?>

            <?php endif; ?>
          <?php endforeach; ?>

          <?php foreach ($names as $name): ?>
            <?php if ($name->getObject()->getEntityTypeId() == QubitTerm::PERSON_ID): ?>
              <persname role="subject"><?php echo escape_dc(esc_specialchars((string)$name->getObject())) ?></persname>
            <?php elseif ($name->getObject()->getEntityTypeId() == QubitTerm::FAMILY_ID): ?>
              <famname role="subject"><?php echo escape_dc(esc_specialchars((string)$name->getObject())) ?></famname>
            <?php elseif ($name->getObject()->getEntityTypeId() == QubitTerm::CORPORATE_BODY_ID): ?>
              <corpname role="subject"><?php echo escape_dc(esc_specialchars((string)$name->getObject())) ?></corpname>
            <?php else: ?>
              <name role="subject"><?php echo escape_dc(esc_specialchars((string)$name->getObject())) ?></name>
            <?php endif; ?>
          <?php endforeach; ?>

          <?php foreach ($materialTypes as $materialtype): ?>
            <genreform source="rad" <?php if (0 < strlen($encoding = $ead->getMetadataParameter('materialType'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?>><?php echo escape_dc(esc_specialchars((string)$materialtype->getTerm())) ?></genreform>
          <?php endforeach; ?>

          <?php foreach ($genres as $genre): ?>
            <genreform <?php if (0 < strlen($encoding = $ead->getMetadataParameter('genreform'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?>><?php echo escape_dc(escape_dc(esc_specialchars((string)$genre->getTerm()))) ?></genreform>
          <?php endforeach; ?>

          <?php foreach ($subjects as $subject): ?>
            <subject><?php echo escape_dc(esc_specialchars((string)$subject->getTerm())) ?></subject>
          <?php endforeach; ?>

          <?php foreach ($places as $place): ?>
            <geogname><?php echo escape_dc(esc_specialchars((string)$place->getTerm())) ?></geogname>
          <?php endforeach; ?>

          <?php foreach ($placeEvents as $place): ?>
            <geogname role="<?php echo $place->getObject()->getType()->getRole() ?>" <?php if (0 < strlen($encoding = $ead->getMetadataParameter('geog'.$place->getObject()->getType()->getRole()))): ?>encodinganalog="<?php echo $encoding ?>"<?php elseif (0 < strlen($encoding = $ead->getMetadataParameter('geogDefault'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?> id="atom_<?php echo $place->objectId ?>_place"><?php echo escape_dc(esc_specialchars((string)$place->getTerm())) ?></geogname>
          <?php endforeach; ?>

        </controlaccess>

      <?php endif; ?>

      <?php if (0 < strlen($value = $descendant->getPhysicalCharacteristics(array('cultureFallback' => true)))): ?>
        <phystech encodinganalog="<?php echo $ead->getMetadataParameter('phystech') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></phystech>
      <?php endif; ?>

      <?php if (0 < strlen($value = $descendant->getAppraisal(array('cultureFallback' => true)))): ?>
        <appraisal <?php if (0 < strlen($encoding = $ead->getMetadataParameter('appraisal'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?>><p><?php echo escape_dc(esc_specialchars($value)) ?></p></appraisal>
      <?php endif; ?>

      <?php if (0 < strlen($value = $descendant->getAcquisition(array('cultureFallback' => true)))): ?>
        <acqinfo encodinganalog="<?php echo $ead->getMetadataParameter('acqinfo') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></acqinfo>
      <?php endif; ?>

      <?php if (0 < strlen($value = $descendant->getAccruals(array('cultureFallback' => true)))): ?>
        <accruals encodinganalog="<?php echo $ead->getMetadataParameter('accruals') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></accruals>
      <?php endif; ?>

      <?php if (0 < strlen($value = $descendant->getArchivalHistory(array('cultureFallback' => true)))): ?>
        <custodhist encodinganalog="<?php echo $ead->getMetadataParameter('custodhist') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></custodhist>
      <?php endif; ?>

      <?php if (0 < strlen($value = $descendant->getRevisionHistory(array('cultureFallback' => true)))): ?>
        <processinfo><p><date><?php echo escape_dc(esc_specialchars($value)) ?></date></p></processinfo>
      <?php endif; ?>

      <?php if (0 < count($archivistsNotes = $descendant->getNotesByType(array('noteTypeId' => QubitTerm::ARCHIVIST_NOTE_ID)))): ?>
        <?php foreach ($archivistsNotes as $note): ?>
          <processinfo><p><?php echo escape_dc(esc_specialchars($note->getContent(array('cultureFallback' => true)))) ?></p></processinfo>
        <?php endforeach; ?>
      <?php endif; ?>

      <?php if (0 < strlen($value = $descendant->getLocationOfOriginals(array('cultureFallback' => true)))): ?>
        <originalsloc encodinganalog="<?php echo $ead->getMetadataParameter('originalsloc') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></originalsloc>
      <?php endif; ?>

      <?php if (0 < strlen($value = $descendant->getLocationOfCopies(array('cultureFallback' => true)))): ?>
        <altformavail encodinganalog="<?php echo $ead->getMetadataParameter('altformavail') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></altformavail>
      <?php endif; ?>

      <?php if (0 < strlen($value = $descendant->getRelatedUnitsOfDescription(array('cultureFallback' => true)))): ?>
        <relatedmaterial encodinganalog="<?php echo $ead->getMetadataParameter('relatedmaterial') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></relatedmaterial>
      <?php endif; ?>

      <?php if (0 < strlen($value = $descendant->getAccessConditions(array('cultureFallback' => true)))): ?>
        <accessrestrict encodinganalog="<?php echo $ead->getMetadataParameter('accessrestrict') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></accessrestrict>
      <?php endif; ?>

      <?php if (0 < strlen($value = $descendant->getReproductionConditions(array('cultureFallback' => true)))): ?>
        <userestrict encodinganalog="<?php echo $ead->getMetadataParameter('userestrict') ?>"><p><?php echo escape_dc(esc_specialchars($value))  ?></p></userestrict>
      <?php endif; ?>

      <?php if (0 < strlen($value = $descendant->getFindingAids(array('cultureFallback' => true)))): ?>
        <otherfindaid encodinganalog="<?php echo $ead->getMetadataParameter('otherfindaid') ?>"><p><?php echo escape_dc(esc_specialchars($value)) ?></p></otherfindaid>
      <?php endif; ?>

      <?php if (0 < count($publicationNotes = $descendant->getNotesByType(array('noteTypeId' => QubitTerm::PUBLICATION_NOTE_ID)))): ?>
        <?php foreach ($publicationNotes as $note): ?>
          <bibliography <?php if (0 < strlen($encoding = $ead->getMetadataParameter('bibliography'))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?>><p><?php echo escape_dc(esc_specialchars($note->getContent(array('cultureFallback' => true)))) ?></p></bibliography>
        <?php endforeach; ?>
      <?php endif; ?>

      <?php foreach($radNotes as $name => $xmlType): ?>
          <?php $noteTypeId = array_search($name, $termData['radNoteTypes']['en']); ?>

          <?php if (0 < count($notes = $descendant->getNotesByType(array('noteTypeId' => $noteTypeId)))): ?>
            <?php foreach ($notes as $note): ?>
              <odd type="<?php echo $xmlType ?>" <?php if (0 < strlen($encoding = $ead->getMetadataParameter($xmlType))): ?>encodinganalog="<?php echo $encoding ?>"<?php endif; ?>><p><?php echo escape_dc(esc_specialchars($note->getContent(array('cultureFallback' => true)))) ?></p></odd>
            <?php endforeach; ?>
          <?php endif; ?>
      <?php endforeach; ?>

      <?php if ($descendant->rgt == $descendant->lft + 1): ?>
        </c>
      <?php else: ?>
        <?php array_push($nestedRgt, $descendant->rgt) ?>
      <?php endif; ?>

    <?php endforeach; ?>

    <?php // Make sure all <c> tags are closed ?>
    <?php while (count($nestedRgt) > 0): ?>
      <?php array_pop($nestedRgt); ?>
      </c>
    <?php endwhile; ?>

  </dsc>
  <?php endif; ?>
</archdesc>
</ead>
